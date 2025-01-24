# Auth-PHP
A simple library for creating and managing users and authentication in PHP
The Library provides a simple and effective way to handle user authentication in your PHP applications. It allows for user registration, login, logout, and session management using cookies. This library also hashes passwords for secure storage.


## Installation

You can install this package via Composer:

```bash
composer require natilosir/Auth
```
## Usage
```php
use natilosir\auth\auth;
```
Ensure that you have the required dependencies for cookie management and database operations.

Hashing Passwords
The library provides a hashing function to securely hash passwords using MD5. You can call this function directly:

```php
$passwordHash = hash($password);
```
## Registering a User
To register a new user, use the register method:

```php
$response = Auth::register('user@example.com', 'securepassword');
```
This method returns an array indicating the status of the registration.

## Logging In
To log in a user, use the attempt method:

```php
$user = Auth::attempt('user@example.com', 'securepassword');
if ($user) {
    echo 'Login successful!';
} else {
    echo 'Login failed!';
}
```
## Logging Out
To log out the current user, simply call:

```php
Auth::logout();
```
## Checking User Status
To check if a user is logged in and retrieve their information:

```php
$userInfo = Auth::check();
```
## Getting All Users
To retrieve all registered users:

```php
$allUsers = Auth::getAllUsers();
```
## Retrieving User from Cookie
To get the currently logged-in user from the cookie:

```php
$currentUser = Auth::getUserFromCookie();
```
## Getting User ID
To retrieve the ID of the currently logged-in user:

```php
$userId = Auth::id();
```
# Functions
`hash($password)`
Hashes the provided password using MD5 and returns a substring of the hash from the 5th to the 15th character.

`Auth::attempt($username, $password)`
Attempts to log in a user with the provided username (email or username) and password.

`Auth::register($username, $password)`
Registers a new user with the specified username (email or username) and password.

`Auth::logout()`
Logs out the current user by deleting the user cookie.

`Auth::check()`
Checks the authentication status of the user and returns user information.

`Auth::getUserFromCookie()`
Retrieves the username from the cookie.

`Auth::getAllUsers()`
Returns an array of all registered users.

`Auth::user()`
Returns the currently logged-in user.

`Auth::id()`
Returns the ID of the currently logged-in user.

`Auth::login($user)`
Logs in a user by setting the user cookie.

`Auth::loginUsingId($id)`
Logs in a user using their ID.
