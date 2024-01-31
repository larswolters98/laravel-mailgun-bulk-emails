# Laravel & Mailgun bulk email sending

This is an example on how to send bulk emails in Laravel 10 using the Mailgun API. The problem with queueing bulk emails is
that you can't use the `Mail::queue()` method because it will create a new job for each email. This will cause the queue
to grow very fast and eventually crash.

A solution to this problem is to make use of the Mailgun API. Mailgun allows you to send up to 1000 emails per batch.
This means that you can send 1000 emails with a single API call. This example project will show you how to do this.

## Installation

1. Clone this repository & run `composer install`
2. Copy `.env.example` to `.env` and fill in your Mailgun API credentials
3. Run `php artisan key:generate`
4. Run `php artisan migrate:fresh --seed`
5. Run `php artisan serve`

## Usage

After you have filled in your Mailgun credentials, you can run a command to send a bulk email:

```
php artisan app:send-example-notification
```

This command will send a bulk email to all users in the database. Since Mailgun only allows you to send 1000 emails per
batch, we chunk the users into groups of 500. This means that if you have 2000 users in your database, the command will
send 4 batches of 500 emails.

## Adding recipient-specific data

Recipient-specific data is added to each recipient by adding a `data` key to the recipient array:

```php
foreach ($recipients as $recipient) {
    $email->addToRecipient($recipient['email'], $recipient['data']);
}
```

In order to change the recipient-specific data, you will need to change the `data` key in the `$recipients` array, for
example:

```php
$sendBulkEmail->execute(
    new ExampleNotification([
        'url' => 'https://example.com',
    ]),
    'Example notification subject',
    $chunk->map(fn($user) => [
        'email' => $user->email,
        'data' => [
            'name' => $user->name
            'client_number' => $user->client_number // This could be some extra data we add
        ],
    ])->toArray()
);
```

We would access this data in the notification view like this:

```html
<x-mail::message>
%recipient.name%
%recipient.client_number%
</x-mail::message>
```

## Mailgun sandbox domains

If you are using a Mailgun sandbox domain, you will need to allow the email addresses you want to send emails to. You
can
seed that user with the allowed domain in order to test the bulk email functionality. If other not-allowed users are
seeded,
and you try to send the email to them, Mailgun will throw an exception.

## Domain zones

If you are using a European Mailgun domain, you will need to set your `MAILGUN_ENDPOINT` environment variable to
`https://api.eu.mailgun.net`. If you are using a US domain, you can leave this config variable empty.

## Testing

This repository is for demonstration purposes, so no tests were written for now.
