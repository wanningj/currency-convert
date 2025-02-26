# 📌 即時匯率轉換API

**即時匯率轉換API** 是一個以Laravel架構開發的API，可以查詢不同貨幣之間的匯率，並進行即時轉換。本API使用SQLite作為資料庫。

## ✨ 功能介紹

- ✅ **支援多種貨幣轉換**
- ✅ **使用模擬匯率**
- ✅ **支援常見貨幣 : TWD, USD, JPY**
- ✅ **取得所有貨幣的模擬匯率**

## 📂 專案結構
````
/currency-convert
├── app/
│   ├── Models/
│   │   ├── Currency.php
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── CurrencyController.php
│   │   ├── Routes/ 
│   │   │   ├── api.php
├── database/
│   ├── database.sqlite  # SQLite資料庫存放位置
│   ├── migrations/
│   │   ├── 2025_02_25_105232_currencies_table.php
│   ├── seeders/         
│   │   ├── CurrencySeeder.php  # 初始資料填充
├── tests/       
│   ├── Feature/
│   │   ├── CurrencyTest.php    #測試
├── .env.example         # 環境變數範例
├── composer.json        # Laravel 依賴管理
├── README.md            # 這個文件
````

## 📌 API使用方式

### 1️⃣ 即時匯率轉換
- Endpoint: POST /currency/convert
- Request example:
```json
    {
        "from_currency":"USD",
        "to_currency":"TWD",
        "amount":100
    }
```
- Response Example:
```json
    {
        "from_currency": "USD",
        "to_currency": "TWD",
        "amount": 100,
        "converted_amount": 3150,
        "rate": 31.5
    }
```

### 2️⃣ 取得所有匯率
- Endpoint: GET /currency
- Response Example:
```json
    [
        {
            "base_currency": "USD",
            "last_updated": "2025-02-26T02:56:32.000000Z",
            "rates": {
                "USD": 1,
                "TWD": 31.5,
                "JPY": 148.5
            }
        },
        {
            "base_currency": "TWD",
            "last_updated": "2025-02-26T02:56:32.000000Z",
            "rates": {
                "USD": 0.0317,
                "TWD": 1,
                "JPY": 4.7143
            }
        },
        {
            "base_currency": "JPY",
            "last_updated": "2025-02-26T02:56:32.000000Z",
            "rates": {
                "USD": 0.00673,
                "TWD": 0.2121,
                "JPY": 1
            }
        }
    ]
```

### 3️⃣ 新增匯率
- Endpoint: POST /store
- Request example:
```json
    {
        "base_currency":"EUR",
        "convert_currency":"TWD",
        "rate":34.4571
    }
```
- Response Example:
```json
    {
        "base_currency": "EUR",
        "convert_currency": "TWD",
        "rate": 34.4571,
        "updated_at": "2025-02-26T02:53:38.000000Z",
        "created_at": "2025-02-26T02:53:38.000000Z",
        "id": 10
    }
```

## 📬 聯絡資訊

- 作者: Wan-Ning
- Email: sly163369@gmail.com
- GitHub: wanningj