# API DOCUMENTAION

## AUTHENTICATION

#### LOGIN (POST)

```http
  https://f.mmsdev.site/api/v1/login
```

| Arguments | Type   | Description                |
| :-------- | :----- | :------------------------- |
| email     | sting  | **Required** lpp@gmail.com |
| password  | string | **Required** asdffdsa      |

##### Note : Tokens will be returned if login process is successful. But tokens will not be returned if a user is banned.

#### LOGOUT (POST)

```http
  http://127.0.0.1:8000/api/v1/logout
```

#### LOGOUT ALL DEVICES (POST)

```http
  http://127.0.0.1:8000/api/v1/logout-all
```

#### GET ALL DEVICES (GET)

```http
  http://127.0.0.1:8000/api/v1/devices
```

---

## USER MANAGEMENT

###### Note : Only Admin can manage users. So basically, a normal staff cannot access these routes.

#### USERS LIST (GET)

```http
 http://127.0.0.1:8000/api/v1/user
```

#### BANNED-USERS LIST (GET)

```http
 http://127.0.0.1:8000/api/v1/user/banned-users
```

#### CREATE USER (REGISTER) (POST)

```http
  http://127.0.0.1:8000/api/v1/user/register
```

| Arguments             | Type   | Description                |
| :-------------------- | :----- | :------------------------- |
| name                  | string | **Required** LPP           |
| position              | enum   | **Required** admin         |
| email                 | string | **Required** lpp@gmail.com |
| password              | string | **Required** asdffdsa      |
| password_confirmation | string | **Required** asdffdsa      |

###### Note : Only Admin can register and manage users.

#### UPDATE USER'S POSITION (PUT)

```http
  http://127.0.0.1:8000/api/v1/user/position-management/{id}
```

| Arguments | Type   | Description        |
| :-------- | :----- | :----------------- |
| position  | string | **Required** admin |

###### Note : Only Admin can change user's position.

#### BAN USER (PUT)

```http
  http://127.0.0.1:8000/api/v1/user/ban/{id}
```

#### UNBAN USER (PUT)

```http
  http://127.0.0.1:8000/api/v1/user/unban/{id}
```

---

## BLOG

#### BLOG LIST (GET)

```http
  http://127.0.0.1:8000/api/v1/blog
```

###### Note : You can search the record in the list by passing "keyword" parameter in route URL. Example below.

```http
  http://127.0.0.1:8000/api/v1/blog&keyword=hello
```

###### Note : By default the list will be shown from the latest to earliest records. You can make it show from the earliest by passing just "id" parameter in route URL.

#### SHOW A PARTICULAR BLOG (GET)

```http
  http://127.0.0.1:8000/api/v1/blog/{id}
```

#### STORE (or) CREATE A BLOG (POST)

```http
  http://127.0.0.1:8000/api/v1/blog
```

| Arguments   | Type    | Description                  |
| :---------- | :------ | :--------------------------- |
| title       | string  | **Required** Hello World     |
| content     | string  | **Required** loream ipsum... |
| category_id | integer | **Required** 1               |
| user_id     | integer | **Required** 1               |

#### UPDATE BLOG (PATCH)

```http
  http://127.0.0.1:8000/api/v1/blog/{id}
```

| Arguments   | Type    | Description                  |
| :---------- | :------ | :--------------------------- |
| title       | string  | **Nullable** Hello World     |
| content     | string  | **Nullable** loream ipsum... |
| category_id | integer | **Nullable** 1               |
| user_id     | integer | **Nullable** 1               |

#### DELETE BLOG (DELETE)

```http
  http://127.0.0.1:8000/api/v1/blog/{id}
```

---

## CATEGORY

#### CATEGORY LIST (GET)

```http
  http://127.0.0.1:8000/api/v1/category
```

###### Note : You can search the record in the list by passing "keyword" parameter in route URL. Example below.

```http
  http://127.0.0.1:8000/api/v1/category&keyword=local news
```

###### Note : By default the list will be shown from the latest to earliest records. You can make it show from the earliest by passing just "id" parameter in route URL.

#### SHOW A PARTICULAR CATEGORY (GET)

```http
  http://127.0.0.1:8000/api/v1/category/{id}
```

#### STORE (or) CREATE A CATEGORY (POST)

```http
  http://127.0.0.1:8000/api/v1/category
```

| Arguments | Type    | Description         |
| :-------- | :------ | :------------------ |
| title     | string  | **Required** Sports |
| user_id   | integer | **Required** 1      |

#### UPDATE CATEGORY (PATCH)

```http
  http://127.0.0.1:8000/api/v1/category/{id}
```

| Arguments | Type    | Description              |
| :-------- | :------ | :----------------------- |
| title     | string  | **Nullable** Hello World |
| user_id   | integer | **Nullable** 1           |

#### DELETE CATEGORY (DELETE)

```http
  http://127.0.0.1:8000/api/v1/category/{id}
```

---
