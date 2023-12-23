### PriceChangeService Overview

**Description:**
The PriceChangeService is a web service designed to monitor and track changes in the prices of advertisements on OLX. It provides a convenient way for users to subscribe to price changes for specific advertisements and receive email notifications when the prices are updated.

**Key Features:**
1. **Subscription to Price Changes:**
   Users can subscribe to receive notifications about changes in the price of a particular advertisement. To subscribe, they need to provide the advertisement link and their email address.

2. **Price Tracking:**
   The service actively monitors the price of the subscribed advertisements and automatically tracks any changes.

3. **Email Notifications:**
   Upon successful subscription and detection of a price change, the service sends email notifications to the specified email address.

4. **Programming Language:**
   The PriceChangeService is implemented using the PHP programming language.

**Implementation Details:**

- **PriceHelper.php (Location: PhpstormProjects\PriceChangeService\app\Helpers\PriceHelper.php):**
  This file is responsible for parsing the web page of the advertisement to retrieve the current price.

- **Console Commands:**
  - `Kernel.php (Location: PhpstormProjects\PriceChangeService\app\Console\Kernel.php):`
    The console kernel that schedules and manages the execution of console commands.
  - `MyCustomCommand.php (Location: PhpstormProjects\PriceChangeService\app\Console\Commands\MyCustomCommand.php):`
    Custom console command(s) related to the functionality of the service.

- **Controllers (Location: PhpstormProjects\PriceChangeService\app\Http\Controllers\):**
  - `EmailVerificationController.php`
  - `PriceTrackerController.php`
  - `Controller.php`
  These controllers handle the HTTP requests, including subscription requests and email verification.

- **Mail (Location: PhpstormProjects\PriceChangeService\app\Mail\):**
  - `EmailNotificationDeleted.php`
  - `EmailNotification.php`
  - `EmailVerification.php`
  Classes representing email notifications and verification emails.

- **Models (Location: PhpstormProjects\PriceChangeService\app\Models\):**
  - `PriceTracker.php`
  Represents the model for tracking the price changes of advertisements.

- **Database Migration (Location: PhpstormProjects\PriceChangeService\app\Models\2023_12_21_182636_create_price_trackers_table.php):**
  Migration file for creating the database table related to price trackers.

- **Views (Location: PhpstormProjects\PriceChangeService\resources\views\):**
  - `subscribe.blade.php`
  - `emails\email-notification.blade.php`
  - `emails\email-notification-deleted.blade.php`
  - `emails\email-verification.blade.php`
  - `verification\success.blade.php`
  - `verification\error.blade.php`
  Blade templates for rendering HTML views related to subscription, email notifications, and email verification.

- **Routes (Location: PhpstormProjects\PriceChangeService\routes\web.php):**
  Defines the web routes for handling subscription, verification, and other related functionalities.

**Note:** Ensure that you keep your README.md file updated with any changes to the service, and provide clear instructions on how users can interact with and integrate the PriceChangeService into their projects.