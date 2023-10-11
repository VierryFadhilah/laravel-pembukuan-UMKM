# PEMBUKUAN UMKM API SPECS

## POST LOGIN

Method: POST

EndPoint: /api/login

request:

```json
{
    "email": "",
    "password": "kata_sandi_rahasia"
}
```

response :

```json
{
    "status": "success",
    "message": "Login berhasil",
    "data": {
        "id": 123,
        "name": "pengguna_contoh",
        "token": "token_access_jwt"
    }
}
```

response gagal :

```json
{
    "status": "error",
    "message": "Login gagal. Nama pengguna atau kata sandi tidak valid."
}
```

## ATURAN

setiap request harus memiliki header:

Authorization: Bearer <token_access_jwt>

## CREATE USER

Method: POST

EndPoint: /api/users

request:

```json
{
    "name": "pengguna_baru",
    "email": "contoh@contoh.com",
    "password": "kata_sandi_rahasia",
    "roles": 0
}
```

response :

```json
{
    "status": "success",
    "message": "Pengguna berhasil dibuat.",
    "data": {
        "id": 124,
        "name": "pengguna_baru",
        "email": "contoh@contoh.com"
    }
}
```

response gagal :

```json
{
    "status": "error",
    "message": "Pengguna tidak dapat dibuat. Mohon periksa data yang dikirim."
}
```

## GET USERS

Method: GET

EndPoint: /api/users

params :

    limit=
    search=
    page=

response :

```json
{
    "status": "success",
    "message": "success ambil data",
    "data": [
        {
            "id": 0,
            "name": "",
            "email": "",
            "roles": ""
        },
        ... //sebanyak limit
    ]
}
```

## Get One User

Method: GET

EndPoint: /api/users/:id

response :

```json
{
    "status": "success",
    "message": "success ambil data",
    "data": {
        "id": 0,
        "name": "",
        "email": "",
        "roles": "",
        "password": ""
    }
}
```

## Update User

Method : PUT

Endpoint : /users/:id

request:

```json
{
    "id": 0,
    "name": "pengguna_baru",
    "email": "contoh@contoh.com",
    "password": "kata_sandi_rahasia",
    "roles": 0
}
```

response :

```json
{
    "status": "success",
    "message": "Pengguna berhasil diUpdate.",
    "data": {
        "user_id": 124,
        "username": "pengguna_baru",
        "email": "contoh@contoh.com"
    }
}
```

## Create ROLES

Method: POST

EndPoint: /api/roles

request:

```json
{
    "name": "",
    "desc": "",
    "access": []
}
```

response :

```json
{
    "status": "success",
    "message": "Roles berhasil dibuat.",
    "data": {
        "id": 124,
        "name": ""
    }
}
```

## Get Roles

Method: GET

EndPoint: /api/roles

params :

    limit=
    search=
    page=

response :

```json
{
    "status": "success",
    "message": "success ambil data",
    "data": [
        {
            "id": 0,
            "name": "",
            "desc": "",
        },
        ... //sebanyak limit
    ]
}
```

## Get One Roles

Method: GET

EndPoint: /api/roles/:id

response :

```json
{
    "status": "success",
    "message": "success ambil data",
    "data": {
        "id": 0,
        "name": "",
        "desc": "",
        "access": [
            "",
            ... // sebanyak accesss
        ],
    }
}
```

## Update Roles

Method : PUT

Endpoint : /roles/:id

request:

```json
{
    "id": 0,
    "name": "",
    "desc": "",
    "access": []
}
```

response :

```json
{
    "status": "success",
    "message": "Roles berhasil Diupdate.",
    "data": {
        "id": 124,
        "name": ""
    }
}
```
