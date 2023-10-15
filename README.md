# PEMBUKUAN UMKM API SPECS

## POST LOGIN

Method: POST

EndPoint: /api/login

request:

```json
{
    "email": "test@gmail.com",
    "password": "password"
}
```

response :

```json
{
    "status": "success",
    "message": "Login berhasil",
    "data": {
        "user": {
            "id": 1,
            "name": "test",
            "email": "test@gmail.com",
            "roles_id": 1,
            "created_at": null,
            "updated_at": null
        },
        "token": "2|Qrv7YQyeyrBPeTYrZgfYd4P77u5mFESp3X9uOURj9073a11c"
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
    "name": "pengguna 4",
    "email": "test4@mail.com",
    "password": "password",
    "roles_id": 1
}
```

response :

```json
{
    "status": "success",
    "message": "Pengguna berhasil disimpan",
    "data": {
        "name": "pengguna 4",
        "email": "test4@mail.com",
        "updated_at": "2023-10-13T08:51:52.000000Z",
        "created_at": "2023-10-13T08:51:52.000000Z",
        "id": 2
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

    limit:10
    sort:name
    order:desc
    page:1
    search:o

response :

```json
{
    "status": "success",
    "message": "Berhasil ambil data dengan paginasi",
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": 1,
                "name": "test",
                "email": "test@gmail.com",
                "roles_name": "owner"
            },
            {
                "id": 2,
                "name": "pengguna 4",
                "email": "test4@mail.com",
                "roles_name": null
            }
        ],
        "first_page_url": "http://127.0.0.1:8000/api/users?limit=10&search=o&sort=name&order=desc&page=1",
        "from": 1,
        "last_page": 1,
        "last_page_url": "http://127.0.0.1:8000/api/users?limit=10&search=o&sort=name&order=desc&page=1",
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "active": false
            },
            {
                "url": "http://127.0.0.1:8000/api/users?limit=10&search=o&sort=name&order=desc&page=1",
                "label": "1",
                "active": true
            },
            {
                "url": null,
                "label": "Next &raquo;",
                "active": false
            }
        ],
        "next_page_url": null,
        "path": "http://127.0.0.1:8000/api/users",
        "per_page": 10,
        "prev_page_url": null,
        "to": 2,
        "total": 2
    }
}
```

## GET ONE USER

Method: GET

EndPoint: /api/users/:id

response :

```json
{
    "status": "success",
    "message": "User found",
    "data": {
        "id": 2,
        "name": "pengguna 4",
        "email": "test4@mail.com",
        "roles_id": null,
        "created_at": "2023-10-13T08:51:52.000000Z",
        "updated_at": "2023-10-13T08:51:52.000000Z"
    }
}
```

## Update User

Method : PUT

Endpoint : api//users/:id

request:

```json
{
    "name": "pengguna 555",
    "email": "test555@mail.com",
    "roles_id": 2
}
```

response :

```json
{
    "status": "success",
    "message": "User Berhasil di update",
    "data": {
        "id": 10,
        "name": "pengguna 555",
        "email": "test555@mail.com",
        "roles_id": 2,
        "created_at": "2023-10-13T09:31:56.000000Z",
        "updated_at": "2023-10-13T09:32:48.000000Z"
    }
}
```

## DELETE USER

Method : DELETE

EndPoint: /api/users/:id

response:

```json
{
    "status": "success",
    "message": "User berhasil dihapus"
}
```

## Create ROLES

Method: POST

EndPoint: /api/roles

request:

```json
{
    "name": "karyawan",
    "description": "membuka menu Keuangan",
    "access": [1, 2]
}
```

response :

```json
{
    "status": "success",
    "message": "Roles berhasil disimpan",
    "data": {
        "name": "karyawan",
        "description": "membuka menu Keuangan",
        "updated_at": "2023-10-13T09:34:47.000000Z",
        "created_at": "2023-10-13T09:34:47.000000Z",
        "id": 4
    }
}
```

## GET ROLES

Method: GET

EndPoint: /api/roles

params :

    limit:10
    sort:name
    order:desc
    page:1
    search:a

response :

```json
{
    "status": "success",
    "message": "Berhasil ambil data dengan paginasi",
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": 2,
                "name": "kasir2",
                "description": "membuka menu karywan"
            },
            {
                "id": 4,
                "name": "karyawan",
                "description": "membuka menu Keuangan"
            }
        ],
        "first_page_url": "http://127.0.0.1:8000/api/roles?limit=10&search=a&sort=name&order=desc&page=1",
        "from": 1,
        "last_page": 1,
        "last_page_url": "http://127.0.0.1:8000/api/roles?limit=10&search=a&sort=name&order=desc&page=1",
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "active": false
            },
            {
                "url": "http://127.0.0.1:8000/api/roles?limit=10&search=a&sort=name&order=desc&page=1",
                "label": "1",
                "active": true
            },
            {
                "url": null,
                "label": "Next &raquo;",
                "active": false
            }
        ],
        "next_page_url": null,
        "path": "http://127.0.0.1:8000/api/roles",
        "per_page": 10,
        "prev_page_url": null,
        "to": 2,
        "total": 2
    }
}
```

## Get One Roles

Method: GET

EndPoint: /api/roles/:id

response :

```json
{
    "status": "success",
    "message": "Role found",
    "data": {
        "id": 4,
        "name": "karyawan",
        "description": "membuka menu Keuangan",
        "created_at": "2023-10-13T09:34:47.000000Z",
        "updated_at": "2023-10-13T09:34:47.000000Z",
        "access": [1, 2]
    }
}
```

## UPDATE ROLES

Method : PUT

Endpoint : /roles/:id

request:

```json
{
    "name": "karyawan 2",
    "description": "membuka menu karywan",
    "access": [1, 2, 3]
}
```

response :

```json
{
    "status": "success",
    "message": "Role updated successfully",
    "data": {
        "id": 2,
        "name": "karyawan 2",
        "description": "membuka menu karywan",
        "created_at": "2023-10-12T18:31:58.000000Z",
        "updated_at": "2023-10-13T09:45:52.000000Z"
    }
}
```

## DELETE ROLES

Method: DELETE

EndPoint: /api/roles/:id

response :

```json
{
    "status": "success",
    "message": "Role delete successfully"
}
```

## CREATE TRANSAKSI

Method : post

Endpoint : /api/transaksi

request :

```json
{
    "tanggal_transaksi": "15-10-2023 00:12:19",
    "description": "duit masuk",
    "user_id": 1,
    "jenis": "pemasukan",
    "kategori_id": 21,
    "nominal": 20000
}
```

response

```json
{
    "status": "success",
    "message": "Transaksi berhasil disimpan",
    "data": {
        "user_id": 1,
        "tanggal_transaksi": "2023-10-15 00:00:00",
        "kategori_id": 21,
        "description": "duit masuk",
        "nominal": 20000,
        "updated_at": "2023-10-15T12:35:00.000000Z",
        "created_at": "2023-10-15T12:35:00.000000Z",
        "id": 14
    }
}
```
