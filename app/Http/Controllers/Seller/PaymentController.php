<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Mail\SellerWelcomeMail;
use App\Models\SellerSubscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    private $shopId;
    private $secretKey;
    private $apiUrl;

    public function __construct()
    {
        $this->shopId = config('yookassa.shop_id');
        $this->secretKey = config('yookassa.secret_key');
        $this->apiUrl = config('yookassa.api_url');
    }

    /**
     * Отображение страницы оплаты (обработка GET-запроса)
     */
    public function showPaymentPage(Request $request)
    {
        try {
            $subscription = SellerSubscription::with(['plan'])->findOrFail($request->subscription);
            
            // Если это бесплатный план, перенаправить на страницу продуктов
            if ($subscription->plan->price == 0) {
                return redirect()->route('seller.products.index');
            }

            // Проверка конфигурации
            if (!$this->shopId || !$this->secretKey) {
                \Log::error('YooKassa configuration is missing', [
                    'shop_id' => $this->shopId,
                    'secret_key' => $this->secretKey ? 'set' : 'missing'
                ]);
                
                return redirect()->route('seller.index')
                    ->with('error', 'Платежная система не настроена.');
            }

            // Запись информации аутентификации (только для отладки, следует удалить в производственной среде)
            \Log::info('YooKassa credentials check in showPaymentPage', [
                'shop_id' => $this->shopId,
                'secret_key' => $this->secretKey,
                'shop_id_length' => strlen($this->shopId),
                'secret_key_length' => strlen($this->secretKey),
                'shop_id_prefix' => substr($this->shopId, 0, 5),
                'secret_key_prefix' => substr($this->secretKey, 0, 10)
            ]);

            // Создание платежа YooKassa - использование правильного метода аутентификации
            $idempotenceKey = Str::uuid()->toString();
            
            // Убедиться, что shopId и secretKey не равны null
            if (is_null($this->shopId) || is_null($this->secretKey)) {
                throw new \Exception('YooKassa credentials are not properly configured');
            }
            
            // Использование базовой аутентификации, но ручное создание заголовка аутентификации
            $auth = base64_encode($this->shopId . ':' . $this->secretKey);
            
            $response = Http::withHeaders([
                    'Authorization' => 'Basic ' . $auth,
                    'Idempotence-Key' => $idempotenceKey,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ])
                ->post("{$this->apiUrl}/payments", [
                    'amount' => [
                        'value' => number_format($subscription->plan->price, 2, '.', ''),
                        'currency' => 'RUB',
                    ],
                    'capture' => true,
                    'confirmation' => [
                        'type' => 'redirect',
                        'return_url' => route('seller.payment.return', ['subscription' => $subscription->id]),
                    ],
                    'description' => "Оплата тарифа {$subscription->plan->name}",
                    'metadata' => [
                        'subscription_id' => $subscription->id,
                    ]
                ]);

            if ($response->successful()) {
                $payment = $response->json();
                
                // Сохранение ID транзакции
                $subscription->update([
                    'transaction_id' => $payment['id'],
                    'payment_method' => 'yookassa'
                ]);
                
                // Проверка наличия URL подтверждения в ответе
                $confirmationUrl = $payment['confirmation']['confirmation_url'] ?? null;
                if (!$confirmationUrl) {
                    \Log::error('Missing confirmation URL in YooKassa response', [
                        'response' => $payment
                    ]);
                    throw new \Exception('Invalid payment response from YooKassa');
                }
                
                // Перенаправление на страницу оплаты
                return redirect()->away($confirmationUrl);
            } else {
                \Log::error('YooKassa payment creation failed in showPaymentPage', [
                    'status' => $response->status(),
                    'response' => $response->body(),
                    'subscription_id' => $subscription->id
                ]);
                throw new \Exception('Payment creation failed: ' . $response->status());
            }
        } catch (\Exception $e) {
            \Log::error('Payment processing error in showPaymentPage', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Создание платежа не удалось
            return redirect()->route('seller.index')
                ->with('error', 'Не удалось создать платеж. Пожалуйста, попробуйте еще раз.(' . $e->getMessage() . ')');
        }
    }

    /**
     * Обработка платежа (POST-запрос)
     */
    public function pay(Request $request)
    {
        try {
            $subscription = SellerSubscription::with(['plan'])->findOrFail($request->subscription);
            
            // Если это бесплатный план, перенаправить на страницу продуктов
            if ($subscription->plan->price == 0) {
                return redirect()->route('seller.products.index');
            }

            // Проверка конфигурации
            if (!$this->shopId || !$this->secretKey) {
                \Log::error('YooKassa configuration is missing', [
                    'shop_id' => $this->shopId,
                    'secret_key' => $this->secretKey ? 'set' : 'missing'
                ]);
                
                return redirect()->route('seller.index')
                    ->with('error', 'Платежная система не настроена.');
            }

            // Запись информации аутентификации (только для отладки, следует удалить в производственной среде)
            \Log::info('YooKassa credentials check in pay method', [
                'shop_id' => $this->shopId,
                'secret_key' => $this->secretKey,
                'shop_id_length' => strlen($this->shopId),
                'secret_key_length' => strlen($this->secretKey),
                'shop_id_prefix' => substr($this->shopId, 0, 5),
                'secret_key_prefix' => substr($this->secretKey, 0, 10)
            ]);

            // Создание платежа YooKassa - использование правильного метода аутентификации
            $idempotenceKey = Str::uuid()->toString();
            
            // Убедиться, что shopId и secretKey не равны null
            if (is_null($this->shopId) || is_null($this->secretKey)) {
                throw new \Exception('YooKassa credentials are not properly configured');
            }
            
            // Использование базовой аутентификации, но ручное создание заголовка аутентификации
            $auth = base64_encode($this->shopId . ':' . $this->secretKey);
            
            $response = Http::withHeaders([
                    'Authorization' => 'Basic ' . $auth,
                    'Idempotence-Key' => $idempotenceKey,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ])
                ->post("{$this->apiUrl}/payments", [
                    'amount' => [
                        'value' => number_format($subscription->plan->price, 2, '.', ''),
                        'currency' => 'RUB',
                    ],
                    'capture' => true,
                    'confirmation' => [
                        'type' => 'redirect',
                        'return_url' => route('seller.payment.return', ['subscription' => $subscription->id]),
                    ],
                    'description' => "Оплата тарифа {$subscription->plan->name}",
                    'metadata' => [
                        'subscription_id' => $subscription->id,
                    ]
                ]);

            if ($response->successful()) {
                $payment = $response->json();
                
                // Сохранение ID транзакции
                $subscription->update([
                    'transaction_id' => $payment['id'],
                    'payment_method' => 'yookassa'
                ]);
                
                // Проверка наличия URL подтверждения в ответе
                $confirmationUrl = $payment['confirmation']['confirmation_url'] ?? null;
                if (!$confirmationUrl) {
                    \Log::error('Missing confirmation URL in YooKassa response', [
                        'response' => $payment
                    ]);
                    throw new \Exception('Invalid payment response from YooKassa');
                }
                
                // Перенаправление на страницу оплаты
                return redirect()->away($confirmationUrl);
            } else {
                \Log::error('YooKassa payment creation failed in pay method', [
                    'status' => $response->status(),
                    'response' => $response->body(),
                    'subscription_id' => $subscription->id
                ]);
                throw new \Exception('Payment creation failed: ' . $response->status());
            }
        } catch (\Exception $e) {
            \Log::error('Payment processing error in pay method', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Создание платежа не удалось
            return redirect()->route('seller.index')
                ->with('error', 'Не удалось создать платеж. Пожалуйста, попробуйте еще раз.(' . $e->getMessage() . ')');
        }
    }

    /**
     * Обработка возврата платежа
     */
    public function return(Request $request)
    {
        try {
            $subscriptionId = $request->subscription;
            
            if (!$subscriptionId) {
                return redirect()->route('seller.index')
                    ->with('error', 'Неверные данные запроса.');
            }

            $subscription = SellerSubscription::find($subscriptionId);

            if (!$subscription) {
                return redirect()->route('seller.index')
                    ->with('error', 'Подписка не найдена.');
            }

            // Получение регистрационных данных из сессии
            $registrationData = $request->session()->get('seller_registration_data');
            $avatarPath = $request->session()->get('seller_avatar_path');
            
            if (!$registrationData) {
                return redirect()->route('seller.index')
                    ->with('error', 'Регистрационные данные истекли. Пожалуйста, попробуйте еще раз.');
            }

            // Проверка конфигурации
            if (!$this->shopId || !$this->secretKey) {
                \Log::error('YooKassa configuration is missing in return method', [
                    'shop_id' => $this->shopId,
                    'secret_key' => $this->secretKey ? 'set' : 'missing'
                ]);
                
                return redirect()->route('seller.index')
                    ->with('error', 'Платежная система не настроена.');
            }

            // Проверка статуса платежа - использование правильного метода аутентификации
            $idempotenceKey = Str::uuid()->toString();
            
            // Убедиться, что shopId и secretKey не равны null
            if (is_null($this->shopId) || is_null($this->secretKey)) {
                throw new \Exception('YooKassa credentials are not properly configured');
            }
            
            // Использование базовой аутентификации, но ручное создание заголовка аутентификации
            $auth = base64_encode($this->shopId . ':' . $this->secretKey);
            
            $response = Http::withHeaders([
                    'Authorization' => 'Basic ' . $auth,
                    'Idempotence-Key' => $idempotenceKey,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ])
                ->get("{$this->apiUrl}/payments/{$subscription->transaction_id}");

            if ($response->successful()) {
                $payment = $response->json();
                
                if ($payment['status'] !== 'succeeded') {
                    return redirect()->route('seller.index')
                        ->with('error', 'Платеж не был успешно завершен. Статус: ' . ($payment['status'] ?? 'неизвестный'));
                }
            } else {
                \Log::error('Failed to check payment status', [
                    'status' => $response->status(),
                    'response' => $response->body(),
                    'transaction_id' => $subscription->transaction_id
                ]);
                throw new \Exception('Failed to check payment status: ' . $response->status());
            }

            // Проверка, существует ли пользователь
            $user = User::where('email', $registrationData['email'])->first();
            
            if ($user) {
                // Если пользователь существует, обновить его информацию вместо создания нового
                $user->update([
                    'name' => $registrationData['first_name'] . ' ' . $registrationData['last_name'],
                    'phone_number' => $registrationData['phone'],
                    'company_name' => $registrationData['company_name'],
                    'avatar' => $avatarPath ? 'storage/' . $avatarPath : $user->avatar,
                ]);
                // Для существующего пользователя не отправлять письмо с паролем повторно
                $password = null;
            } else {
                // Создание нового пользователя
                // Генерация случайного пароля
                $password = Str::random(12);
                $user = User::create([
                    'uuid' => Str::uuid()->toString(), // Add UUID to prevent database error
                    'name' => $registrationData['first_name'] . ' ' . $registrationData['last_name'],
                    'email' => $registrationData['email'],
                    'password' => Hash::make($password), // Пароль будет отправлен пользователю по электронной почте
                    'phone_number' => $registrationData['phone'],
                    'company_name' => $registrationData['company_name'],
                    'avatar' => $avatarPath ? 'storage/' . $avatarPath : null
                ]);
                
                // Отправка приветственного письма с паролем только новым пользователям
                \Log::info('Attempting to send welcome email', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'mail_config' => [
                        'mailer' => config('mail.default'),
                        'host' => config('mail.mailers.smtp.host'),
                        'port' => config('mail.mailers.smtp.port'),
                        'encryption' => config('mail.mailers.smtp.encryption'),
                        'username' => config('mail.mailers.smtp.username'),
                    ]
                ]);
                
                try {
                    // Send the email immediately instead of queuing
                    Mail::to($user->email)->send(new SellerWelcomeMail($user, $password));
                    \Log::info('Welcome email sent successfully', ['user_id' => $user->id]);
                } catch (\Exception $e) {
                    \Log::error('Failed to send welcome email', [
                        'user_id' => $user->id,
                        'email' => $user->email,
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                    
                    // Even if email fails, continue with the registration process
                    // The user can reset their password later if needed
                    // Add a note in the session that email failed to send
                    session()->flash('email_failed', true);
                }
            }

            // Назначение роли продавца
            $sellerRole = Role::findByName('seller');
            if ($sellerRole && !$user->hasRole($sellerRole)) {
                $user->assignRole($sellerRole);
            }

            // Обновление ID пользователя и статуса оплаты в подписке
            $subscription->update([
                'user_id' => $user->id,
                'payment_status' => 'paid',
                'start_date' => now(),
                'end_date' => now()->addYear()
            ]);

            // Очистка временных данных из сессии
            $request->session()->forget(['seller_registration_data', 'seller_avatar_path']);

            // Вместо автоматического входа пользователя перенаправить на страницу входа и показать сообщение
            $successMessage = 'Вы успешно зарегистрировались!';
            if (isset($password)) {
                if (session()->has('email_failed')) {
                    $successMessage .= 'Ваша учетная запись создана, но по техническим причинам пароль не был отправлен на вашу электронную почту. Пожалуйста, используйте функцию сброса пароля для создания нового пароля.';
                } else {
                    $successMessage .= 'Пароль был отправлен на вашу электронную почту. Если вы не получили его в течение нескольких минут, проверьте папку со спамом или свяжитесь с нами.';
                }
            } else {
                $successMessage .= 'С возвращением!';
            }
            
            return redirect()->route('login')
                ->with('success', $successMessage);
        } catch (\Exception $e) {
            \Log::error('Error in payment return processing', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->route('seller.index')
                ->with('error', 'Ошибка обработки платежа. Пожалуйста, свяжитесь с администратором.(' . $e->getMessage() . ')');
        }
    }

    /**
     * Обработка уведомлений webhook YooKassa
     */
    public function webhook(Request $request)
    {
        try {
            // Получение данных запроса
            $payload = $request->all();
            
            \Log::info('YooKassa webhook received', [
                'event' => $payload['event'] ?? null,
                'payload' => $payload
            ]);
            
            // Проверка подписи webhook (упрощенная проверка)
            // В производственной среде необходимо проверять подпись
            // Для проверки подписи необходимо получить заголовок "Authorization" и сравнить его с хэшем данных
            
            // Пример проверки (необходимо реализовать в производственной среде):
            // $signature = $request->header('Authorization');
            // $expectedSignature = hash_hmac('sha256', json_encode($payload), $this->secretKey);
            // if ($signature !== $expectedSignature) {
            //     \Log::warning('Invalid webhook signature', ['signature' => $signature]);
            //     return response()->json(['error' => 'Invalid signature'], 403);
            // }
            
            // Обработка события успешного платежа
            if (isset($payload['event']) && $payload['event'] === 'payment.succeeded') {
                $payment = $payload['object'];
                
                // Получение ID подписки
                $subscriptionId = $payment['metadata']['subscription_id'] ?? null;
                
                if ($subscriptionId) {
                    $subscription = SellerSubscription::find($subscriptionId);
                    
                    if ($subscription && $subscription->payment_status !== 'paid') {
                        // Обновление статуса подписки
                        $subscription->update([
                            'payment_status' => 'paid',
                            'start_date' => now(),
                            'end_date' => now()->addMonth() // Срок подписки - один месяц
                        ]);
                        
                        \Log::info('Subscription updated via webhook', [
                            'subscription_id' => $subscriptionId,
                            'payment_id' => $payment['id'] ?? null
                        ]);
                    }
                }
            }
            
            // Возврат успешного ответа
            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            \Log::error('Error processing YooKassa webhook', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json(['error' => 'Failed to process webhook'], 500);
        }
    }
}