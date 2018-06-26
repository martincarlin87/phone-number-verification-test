# Digitonic Technical Test

To use your own numverify api key, simply add an entry to your .env file:

    NUMVERIFY_KEY=81e071e119d4cd3185c48a66ee8f06b0

It might be best to use one of your own though as I am getting close to the monthly usage cap for the numverify free tier :)

To run the console command (from within the project directory):

    php artisan phone-numbers:verify input.csv

there is an example `input.csv` included in the project directory but any csv file will do.

Generated csv files are saved within the project directory as `output-Y-m-d-h-i-uniqeid.csv`

It's probably a bit overkill to have a Laravel project for one command - I could have tried Laravel Zero but it is unofficial,
or even a Symfony Console app or built it from scratch but I am more experienced with Laravel and genuinely a lot faster at using it.

## Tests

To run the tests, run `vendor/bin/phpunit` from the project directory.








