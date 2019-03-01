# Internation API.
This's documentation for Internation task using `Symfony v4.2`

## Prerequisites
Make sure that you install `PHP v7.1.3`, `MySQL v5.7` and `composer`

## Development

#### Clone the source

```bash
 git clone https://github.com/Maghraby/internation.git
```

#### Installing

```bash
 cd internation
 composer install
```

###### Create database:

```bash
 php bin/console doctrine:database:create
```

###### Load database schema:

```bash
 php bin/console doctrine:migrations:migrate
```

###### Load data fixtures:

```bash
 php bin/console doctrine:fixtures:load
```

###### Note:
Please don't forget to change database URL from `.env` file

#### ER Digram

![ER Digram](https://lh3.googleusercontent.com/x22yNpkBAFjvW_9VhByxFIRXTR5RnH906zktO7vD7LuiFo22ZPG_6lePPutuJ-eKFrJtLlM9NP9uxYf08HSwIBMTc6bX5Co4JO47zmD-c8EHyN4JfJDlOMfzhzX9mPP6WuGtcd8hsIBxiPqhbQgfanAe7oQ_0m9LlOVAOnhdNy4ndSjgFEueMt1URchqGtQzeaKOveGIBFnVioY07x4QTmnCMsnib2u79EaYBb16IQpJ8w21QpuqAFZzyBNW5lCBOra-dftmzzQLl_oVTmF3sjTSBzbPbW7jmbMOblZs2stet6Fa9VuaM0PS4vWpTwyRzedOzj7m4YCWDPPgSXTj451wsFS6rsZd7DAl3xcYsBTALFBbimhiIQvUj-wzvxS6mSvxuIdIFFPsreaLz2KOn2T-b5RaTGABKDYkwTJ_Rh1rPnBKbsCDDvjaEy0dE-sq-eLWN54sYoXuM8fjDL9XYbK5-bWDyJjWIMe1mzdWW8n4E3RiTVeV1hIhsoEonNKYUwmi9TFQ16q7V-1ms-CgJWkKz38nkNIOqxZa-vEp-MQpYHOuMiJe5cJNvruvjanq1MylSMkyVHsAaUTt3I5Hs6EbBgfQ5T4SI7DvuhZzO8bZfKcAy1Ngpmwjl6EQwgu1Joxc16xFsifBpjLmZ8-i4eAdsJRMLmxzO8nlYbPwswRvy5Pt9T9GG9jSnyXylQ9XStr0sXxxBTtxSLZ4gk0lhDdvDg=w1286-h1294-no)


#### Domain Model Digram.

![ER Digram](https://lh3.googleusercontent.com/ZEatj1qveXydwBLAjwkRolN6SbRKbvTmBttoH_HKciHeDJhvx7-OB7AiR0NjW0lsFeZa6dPwMUgtujWeM0VSECoqL6A8rSTEHp5qwijTQf8TGpFn6b5yvP7kikqR_MFAu3pw7Zt0lWbb2Yo9SWLibVOiPXfaO616Vy3hX-eVYmQOf4unP6CSdDjVJ6wp91gvUAXBzZuepDuS2xunSXB3GyMwvNyFVloggQ8UyPNWIQkf6REQNAzzpJpKhgFKI1cPGU6uxnWwP18DiR75JZ-PoAL4WtJEqlobnRvv-zm0YbNAGbf-b3fukxKdooSp7ycNUIeMJOTaBgSqN4IBuHz8x18DeE-d6miDU-Wb_5Y8wypxtMKWcSGGA9kOE5wultOULhaHhzpZQaoFCGfCPE8sR_RfIFS8MBoaYYuzNRQreYBOoKnH8_FWfluT2p4m8IP3rDIjgUMFHPP8bSgW6pLG2P1qAgqH_GyEpguGSPiD9_EB3jLR-bExeZupnyRWAa82rvJV0qatz3FBUqXanfg033cxvND9nd0qwlRzt7s2Z4lP9rok6h0KupNxRwkGvwIjRL2dBKoI5a49yUMN72JzJMrext2ehNJug-qLavZprb2ZnoT5TM925yFgG93L6ri1Eflc98pztpPYonLAIVLmn7YXvfbH2Aan8MQRAOagbleqR0oFbYYUJs5brXmSQ3eKBlnKWm3Zmq8wFw5768MihhhsIA=w1156-h852-no)

#### Admin Scenario
- Admin Can list all users via `/api/users` using `GET` method.
- Admin Can create users via `/api/users` using `POST` method.
- Admin Can delete a user via `/api/users/{id}` using `DELETE` method.
- Admin Can list all groups via `/api/groups` using `GET` method.
- Admin Can create groups via `/api/groups` using `POST` method.
- Admin Can delete a group that has no users via `/api/groups/{id}` using `DELETE` method.
- Admin Can list all memberships between `users` and `groups` via `/api/memberships` using `GET` method.
- Admin Can create membership between `user` and `group` via `/api/memberships` using `POST` method.
- Admin Can delete membership between `user` and `group` via `/api/memberships/{id}` using `DELETE` method. 


#### API Documentation
Please check `swagger.yml` file

#### Running

```bash
 php bin/console server:run 
```

###### NOTE
use `X-AUTH-TOKEN` header value `REAL_TOKEN` from fixtures.

This will use default port 8000


#### Testing

```bash
 php bin/phpunit
```

###### Note:
Please don't forget to change database URL from `.env.test` file