# YooKassa 集成说明

本项目已集成 YooKassa 支付系统，用于处理卖家套餐的支付。

## 配置步骤

1. 注册 YooKassa 账户:
   - 访问 https://yookassa.ru 并注册商户账户
   - 完成商户认证流程

2. 获取 API 凭证:
   - Shop ID (商店ID)
   - Secret Key (密钥)

3. 配置环境变量:
   在 `.env` 文件中添加以下配置:
   ```
   YOOKASSA_SHOP_ID=your_shop_id
   YOOKASSA_SECRET_KEY=your_secret_key
   ```

## Webhook 配置

为了接收支付状态通知，需要在 YooKassa 仪表板中配置 webhook:

1. 登录 YooKassa 仪表板
2. 进入 Integration > HTTP-notifications
3. 添加以下 URL 作为 webhook:
   ```
   https://yourdomain.com/seller/payment/webhook
   ```
4. 选择事件类型:
   - payment.succeeded
   - payment.canceled (可选)

## 测试

在测试环境中，可以使用 YooKassa 提供的测试卡号进行支付测试。

## 支付流程

1. 用户选择套餐并提交注册表单
2. 如果是付费套餐，系统将重定向到 YooKassa 支付页面
3. 用户完成支付后，YooKassa 将发送 webhook 通知
4. 系统收到通知后激活用户订阅
5. 用户被重定向到成功页面并可以访问卖家仪表板

## 安全说明

- 确保 webhook URL 使用 HTTPS
- 在生产环境中验证 webhook 签名
- 不要在前端暴露 API 密钥