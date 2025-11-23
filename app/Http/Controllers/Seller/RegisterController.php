<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\SellerPlan;
use App\Models\SellerSubscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class RegisterController extends Controller
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
     * 显示卖家注册表单
     */
    public function showRegistrationForm()
    {
        $plans = SellerPlan::all();
        return view('client.seller', compact('plans'));
    }

    /**
     * 显示套餐选择页面
     */
    public function showPlansPage()
    {
        $plans = SellerPlan::all();
        return view('client.seller-plans', compact('plans'));
    }

    /**
     * 处理卖家注册
     */
    public function register(Request $request)
    {
        // 验证输入
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'service_description' => 'required|string|max:300',
            'company_name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'plan_id' => 'required|exists:seller_plans,id',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // 获取套餐信息
        $plan = SellerPlan::findOrFail($validated['plan_id']);

        // 处理上传的logo文件
        $avatarPath = null;
        if ($request->hasFile('logo')) {
            $avatarPath = $request->file('logo')->store('avatars', 'public');
        }

        // 如果是免费套餐，直接创建用户和订阅
        if ($plan->price == 0) {
            // 生成随机密码
            $password = Str::random(12);
            
            // 创建用户
            $user = User::create([
                'uuid' => Str::uuid()->toString(),
                'name' => $validated['first_name'] . ' ' . $validated['last_name'],
                'email' => $validated['email'],
                'password' => Hash::make($password), // 密码将通过电子邮件发送给用户
                'phone_number' => $validated['phone'],
                'company_name' => $validated['company_name'],
                'avatar' => $avatarPath ? 'storage/' . $avatarPath : null
            ]);

            // 分配卖家角色
            $sellerRole = Role::findByName('seller');
            $user->assignRole($sellerRole);

            // 创建卖家订阅
            $subscription = SellerSubscription::create([
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'payment_status' => 'paid',
                'start_date' => now(),
                'end_date' => now()->addYear() // 免费套餐有效期一年
            ]);

            // 发送包含密码的欢迎邮件
            \Mail::to($user->email)->send(new \App\Mail\SellerWelcomeMail($user, $password));

            // 重定向到登录页面并显示俄语消息
            return redirect()->route('login')
                ->with('success', 'Мы отправили учетные данные вашей учетной записи на ваш адрес электронной почты. Пожалуйста, проверьте, чтобы подтвердить, что это ваша учетная запись.');
        }

        // 对于付费套餐，创建临时用户数据并重定向到支付页面
        // 将用户数据存储在session中，支付成功后再创建实际用户
        $request->session()->put('seller_registration_data', $validated);
        $request->session()->put('seller_avatar_path', $avatarPath);

        // 创建临时订阅记录（不设置user_id字段）
        $tempSubscription = SellerSubscription::create([
            'plan_id' => $plan->id,
            'payment_status' => 'pending'
        ]);

        try {
            // 检查配置是否正确
            if (!$this->shopId || !$this->secretKey) {
                \Log::error('YooKassa configuration is missing', [
                    'shop_id' => $this->shopId,
                    'secret_key' => $this->secretKey ? 'set' : 'missing'
                ]);
                
                throw new \Exception('Payment system is not configured properly');
            }

            // 记录认证信息（仅用于调试，生产环境中应删除）
            \Log::info('YooKassa credentials check', [
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
                        'value' => number_format($plan->price, 2, '.', ''),
                        'currency' => 'RUB',
                    ],
                    'capture' => true,
                    'confirmation' => [
                        'type' => 'redirect',
                        'return_url' => route('seller.payment.return', ['subscription' => $tempSubscription->id]),
                    ],
                    'description' => "Оплата тарифа {$plan->name} для пользователя {$validated['email']}",
                    'metadata' => [
                        'subscription_id' => $tempSubscription->id,
                    ]
                ]);

            if ($response->successful()) {
                $payment = $response->json();

                // 保存交易ID
                $tempSubscription->update([
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
                \Log::error('YooKassa payment creation failed', [
                    'status' => $response->status(),
                    'response' => $response->body(),
                    'request_data' => [
                        'amount' => number_format($plan->price, 2, '.', ''),
                        'currency' => 'RUB',
                        'return_url' => route('seller.payment.return', ['subscription' => $tempSubscription->id]),
                    ]
                ]);
                throw new \Exception('Payment creation failed: ' . $response->status());
            }
        } catch (\Exception $e) {
            // 删除临时订阅记录
            $tempSubscription->delete();

            // 记录错误日志
            \Log::error('Payment processing error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // 支付创建失败
            return redirect()->route('seller.index')
                ->with('error', 'Не удалось создать платеж. Пожалуйста, попробуйте еще раз. (' . $e->getMessage() . ')');
        }
    }
}