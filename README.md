## Laravel Mailgun bulk emails

This is an example on how to send bulk emails in Laravel using the Mailgun API. The problem with queueing bulk emails is
that you can't use the `Mail::queue()` method because it will create a new job for each email. This will cause the queue
to grow very fast and eventually crash.

A solution to this problem is to make use of the Mailgun API. Mailgun allows you to send up to 1000 emails per batch. 
This means that you can send 1000 emails with a single API call. This example project will show you how to do this.
