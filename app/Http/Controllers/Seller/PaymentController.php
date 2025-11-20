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
     * 显示支付页面（处理GET请求）
     */
    public function showPaymentPage(Request $request)
    {
        try {
            $subscription = SellerSubscription::with(['plan'])->findOrFail($request->subscription);
            
            // 如果是免费套餐，重定向到产品页面
            if ($subscription->plan->price == 0) {
                return redirect()->route('seller.products.index');
            }

            // 检查配置
            if (!$this->shopId || !$this->secretKey) {
                \Log::error('YooKassa configuration is missing', [
                    'shop_id' => $this->shopId,
                    'secret_key' => $this->secretKey ? 'set' : 'missing'
                ]);
                
                return redirect()->route('seller.index')
                    ->with('error', '支付系统未配置。');
            }

            // 记录认证信息（仅用于调试，生产环境中应删除）
            \Log::info('YooKassa credentials check in showPaymentPage', [
                'shop_id' => $this->shopId,
                'secret_key' => $this->secretKey,
                'shop_id_length' => strlen($this->shopId),
                'secret_key_length' => strlen($this->secretKey),
                'shop_id_prefix' => substr($this->shopId, 0, 5),
                'secret_key_prefix' => substr($this->secretKey, 0, 10)
            ]);

            // 创建 YooKassa 支付 - 使用正确的认证方式
            $idempotenceKey = Str::uuid()->toString();
            
            // 确保 shopId 和 secretKey 不为 null
            if (is_null($this->shopId) || is_null($this->secretKey)) {
                throw new \Exception('YooKassa credentials are not properly configured');
            }
            
            // 使用基本认证方式，但手动构建认证头
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
                
                // 保存交易ID
                $subscription->update([
                    'transaction_id' => $payment['id'],
                    'payment_method' => 'yookassa'
                ]);
                
                // 检查返回的确认URL是否存在
                $confirmationUrl = $payment['confirmation']['confirmation_url'] ?? null;
                if (!$confirmationUrl) {
                    \Log::error('Missing confirmation URL in YooKassa response', [
                        'response' => $payment
                    ]);
                    throw new \Exception('Invalid payment response from YooKassa');
                }
                
                // 重定向到支付页面
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
            
            // 支付创建失败
            return redirect()->route('seller.index')
                ->with('error', '无法创建支付。请再试一次。(' . $e->getMessage() . ')');
        }
    }

    /**
     * 处理支付（POST请求）
     */
    public function pay(Request $request)
    {
        try {
            $subscription = SellerSubscription::with(['plan'])->findOrFail($request->subscription);
            
            // 如果是免费套餐，重定向到产品页面
            if ($subscription->plan->price == 0) {
                return redirect()->route('seller.products.index');
            }

            // 检查配置
            if (!$this->shopId || !$this->secretKey) {
                \Log::error('YooKassa configuration is missing', [
                    'shop_id' => $this->shopId,
                    'secret_key' => $this->secretKey ? 'set' : 'missing'
                ]);
                
                return redirect()->route('seller.index')
                    ->with('error', '支付系统未配置。');
            }

            // 记录认证信息（仅用于调试，生产环境中应删除）
            \Log::info('YooKassa credentials check in pay method', [
                'shop_id' => $this->shopId,
                'secret_key' => $this->secretKey,
                'shop_id_length' => strlen($this->shopId),
                'secret_key_length' => strlen($this->secretKey),
                'shop_id_prefix' => substr($this->shopId, 0, 5),
                'secret_key_prefix' => substr($this->secretKey, 0, 10)
            ]);

            // 创建 YooKassa 支付 - 使用正确的认证方式
            $idempotenceKey = Str::uuid()->toString();
            
            // 确保 shopId 和 secretKey 不为 null
            if (is_null($this->shopId) || is_null($this->secretKey)) {
                throw new \Exception('YooKassa credentials are not properly configured');
            }
            
            // 使用基本认证方式，但手动构建认证头
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
                
                // 保存交易ID
                $subscription->update([
                    'transaction_id' => $payment['id'],
                    'payment_method' => 'yookassa'
                ]);
                
                // 检查返回的确认URL是否存在
                $confirmationUrl = $payment['confirmation']['confirmation_url'] ?? null;
                if (!$confirmationUrl) {
                    \Log::error('Missing confirmation URL in YooKassa response', [
                        'response' => $payment
                    ]);
                    throw new \Exception('Invalid payment response from YooKassa');
                }
                
                // 重定向到支付页面
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
            
            // 支付创建失败
            return redirect()->route('seller.index')
                ->with('error', '无法创建支付。请再试一次。(' . $e->getMessage() . ')');
        }
    }

    /**
     * 处理支付返回
     */
    public function return(Request $request)
    {
        try {
            $subscriptionId = $request->subscription;
            
            if (!$subscriptionId) {
                return redirect()->route('seller.index')
                    ->with('error', '请求数据无效。');
            }

            $subscription = SellerSubscription::find($subscriptionId);

            if (!$subscription) {
                return redirect()->route('seller.index')
                    ->with('error', '未找到订阅。');
            }

            // 从会话中获取注册数据
            $registrationData = $request->session()->get('seller_registration_data');
            $avatarPath = $request->session()->get('seller_avatar_path');
            
            if (!$registrationData) {
                return redirect()->route('seller.index')
                    ->with('error', '注册数据已过期。请重试。');
            }

            // 检查配置
            if (!$this->shopId || !$this->secretKey) {
                \Log::error('YooKassa configuration is missing in return method', [
                    'shop_id' => $this->shopId,
                    'secret_key' => $this->secretKey ? 'set' : 'missing'
                ]);
                
                return redirect()->route('seller.index')
                    ->with('error', '支付系统未配置。');
            }

            // 检查支付状态 - 使用正确的认证方式
            $idempotenceKey = Str::uuid()->toString();
            
            // 确保 shopId 和 secretKey 不为 null
            if (is_null($this->shopId) || is_null($this->secretKey)) {
                throw new \Exception('YooKassa credentials are not properly configured');
            }
            
            // 使用基本认证方式，但手动构建认证头
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
                        ->with('error', '支付未成功完成。状态：' . ($payment['status'] ?? 'unknown'));
                }
            } else {
                \Log::error('Failed to check payment status', [
                    'status' => $response->status(),
                    'response' => $response->body(),
                    'transaction_id' => $subscription->transaction_id
                ]);
                throw new \Exception('Failed to check payment status: ' . $response->status());
            }

            // 检查用户是否已存在
            $user = User::where('email', $registrationData['email'])->first();
            
            if ($user) {
                // 如果用户已存在，更新其信息而不是创建新用户
                $user->update([
                    'name' => $registrationData['first_name'] . ' ' . $registrationData['last_name'],
                    'phone_number' => $registrationData['phone'],
                    'company_name' => $registrationData['company_name'],
                    'avatar' => $avatarPath ? 'storage/' . $avatarPath : $user->avatar,
                ]);
            } else {
                // 创建新用户
                // 生成随机密码
                $password = Str::random(12);
                $user = User::create([
                    'name' => $registrationData['first_name'] . ' ' . $registrationData['last_name'],
                    'email' => $registrationData['email'],
                    'password' => Hash::make($password), // 密码将通过电子邮件发送给用户
                    'phone_number' => $registrationData['phone'],
                    'company_name' => $registrationData['company_name'],
                    'avatar' => $avatarPath ? 'storage/' . $avatarPath : null
                ]);
                
                // 只有新用户才发送包含密码的欢迎邮件
                Mail::to($user->email)->send(new SellerWelcomeMail($user, $password));
            }

            // 分配卖家角色
            $sellerRole = Role::findByName('seller');
            if ($sellerRole && !$user->hasRole($sellerRole)) {
                $user->assignRole($sellerRole);
            }

            // 更新订阅中的用户ID和支付状态
            $subscription->update([
                'user_id' => $user->id,
                'payment_status' => 'paid',
                'start_date' => now(),
                'end_date' => now()->addYear()
            ]);

            // 清除会话中的临时数据
            $request->session()->forget(['seller_registration_data', 'seller_avatar_path']);

            // 不自动登录用户，而是重定向到登录页面并显示消息
            return redirect()->route('login')
                ->with('success', '您已成功注册！' . (isset($password) ? '密码已发送至您的邮箱。' : '欢迎回来！'));
        } catch (\Exception $e) {
            \Log::error('Error in payment return processing', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->route('seller.index')
                ->with('error', '支付处理错误。请联系管理员。(' . $e->getMessage() . ')');
        }
    }

    /**
     * 处理 YooKassa webhook 通知
     */
    public function webhook(Request $request)
    {
        try {
            // 获取请求数据
            $payload = $request->all();
            
            \Log::info('YooKassa webhook received', [
                'event' => $payload['event'] ?? null,
                'payload' => $payload
            ]);
            
            // 验证 webhook 签名（简化版验证）
            // 在生产环境中，您应该验证签名
            
            // 处理支付成功事件
            if (isset($payload['event']) && $payload['event'] === 'payment.succeeded') {
                $payment = $payload['object'];
                
                // 获取订阅ID
                $subscriptionId = $payment['metadata']['subscription_id'] ?? null;
                
                if ($subscriptionId) {
                    $subscription = SellerSubscription::find($subscriptionId);
                    
                    if ($subscription && $subscription->payment_status !== 'paid') {
                        // 更新订阅状态
                        $subscription->update([
                            'payment_status' => 'paid',
                            'start_date' => now(),
                            'end_date' => now()->addMonth() // 订阅期限为一个月
                        ]);
                        
                        \Log::info('Subscription updated via webhook', [
                            'subscription_id' => $subscriptionId,
                            'payment_id' => $payment['id'] ?? null
                        ]);
                    }
                }
            }
            
            // 返回成功响应
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