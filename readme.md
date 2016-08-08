## Public Bierdopje API

[Bierdopje](http://www.bierdopje.com) is a dutch community where series are discussed.

To use the API you need an API key, but it appears no keys are being handed out any more.
This project is aimed at those that still want to experiment with the API but can't get their hands on a key.

## Documentation

Please check out the documentation on [Apiary](http://docs.bierdopje1.apiary.io/)

## Running your own Api

If you prefer to run your _own_ API server you are free to do so. However you'll have to provide your own API key from Bierdopje.

    git clone https://github.com/RobinHoutevelts/bierdopje-api.houtevelts.com.git .
    composer install
    chmod -R 777 storage/
    cp .env.example .env
    php artisan key:generate

Then set your API key in `/.env`

If you need to clear your HTTP cache run

    php artisan httpcache:clear

## Security Vulnerabilities

If you discover a security vulnerability, please send an e-mail to Robin Houtevelts at robin@houtevelts.com. All security vulnerabilities will be promptly addressed.

### License

This project is licensed under the [MIT license](http://opensource.org/licenses/MIT).
