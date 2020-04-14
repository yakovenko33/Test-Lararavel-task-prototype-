#UserModule

Модуль отвечает за регестрацию, вход в приложение, а так же добавление сообщений и их вывод.

###Точки входа API:

- POST: /api/user/register - список вакансий без учета фильтра (города);

| Поле  | Тип | Описание |
| ------------- | ------------- | ------------- |
| email | string | Email Пользователя. **(обязательно)**|
| password | string | Пароль пользователя. **(обязательно)**|
| password_repeat | string | Повторить пароль. **(обязательно)**|

Формат ответа:
```
{
  "data": {
     "user_id": 2 
  },
  "status": "success"
}
```

- POST: /api/user/login - список вакансий без учета фильтра (города) с учетом страницы;

| Поле  | Тип | Описание |
| ------------- | ------------- | ------------- |
| email | string | Email Пользователя. **(обязательно)**|
| password | string | Пароль пользователя. **(обязательно)**|

Формат ответа:
```
{
  "data": {
     "jwt_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJ0ZXN0LmNvbSIsImF1ZCI6InRlc3QuY29tIiwiaWF0IjoxMzU2OTk5NTI0LCJuYmYiOjEzNTcwMDAwMDAsImRhdGEiOnsiaWQiOjYsImVtYWlsIjoiYm90dm90MzNAZ21haWwuY29tIn19.MhtXAC5342smJLOCu0cPJWsg5pTk6rujSpwgiuggL4I"
  },
  "status": "success"
}
```

- POST: /api/user/messages - список вакансий с учетом фильтра (города);

| Поле  | Тип | Описание |
| ------------- | ------------- | ------------- |
| jwt_token | string  | Email Пользователя. **(обязательно)**|
| messages | string | Пароль пользователя. **(обязательно)**|

Формат ответа:
```
{
  "data": {
     "message_id": "1"
  },
  "status": "success"
}
```

- GET: /api/user/all/messages - список вакансий с учетом фильтра (города) и страницы; 

Формат ответа:
```
{
    "data": {
        "messages": [
            {
                "id": 1,
                "user_id": 6,
                "text": "New message",
                "created_at": "2020-04-14 23:14:24"
            }
        ]
    },
    "status": "success"
}
```
