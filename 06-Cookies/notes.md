Cookies and Authentication
==========================

HTTP is stateless
-----------------

What do we think this means?

* no particular order
* no set inputs/outputs
* independent - not part of a process - a one time action

How does this relate to HTTP?

HTTP has no concept of "remembering" or "processes" or "order".

But the way we use websites contradicts this.
Example: Logging in before you can use a site.
This seems like a stateful operation - because order matters and
you have to go through one process to get to the other.

Note: That is all an illusion. There's no such thing as "order" or "process" of
HTTP requests - each one is independent.


HTTP requests do not care about other requests at all - nor can they.
Each HTTP request is standalone.

HTTP header:

    GET / HTTP/1.1
    host: www.somewebsite.com

host is an HTTP header

### Cookies are what we use to *emulate* state

Process for "logging in":

1. Authenticate a user
2. When the user is successfully authenticated, we send back a cookie to the
   client
    * What is a cookie?
    * It's just arbitrary data. Key value pairs usually. (urlencoded)
3. For each subsequent request, the browser sends up the cookie with the
request.
    * The assumption is that only the user that logged in has this cookie.

Note: Cookies are stored on the client.

When are cookies stored on the client? What instructs cookies to be stored on
the client?

### Setting cookies

set-cookie: A conventional HTTP response header. It instructs the client
(browser, command line utility, programming library, whatever) to hold on to the
value after `set-cookie`.

Example:

    set-cookie: reg_fb_ref=deleted; expires=Thu, 01-Jan-1970 00:00:01 GMT;
    Max-Age=-1446588187; path=/; domain=.facebook.com; httponly

The key-value pairs within the cookie value will be set:

    reg_fb_ref=deleted
    expires=Thu, 01-Jan-1970 00:00:01 GMT
    Max-Age=-1446588187
    path=/
    domain=.facebook.com
    httponly


### Sending cookies

How are cookies sent? With the cookie header.

In an HTTP request, whatever cookies have been previously set are sent using the
`cookie` header - looks like key value pairs.

What are the contents of the key values pairs?

The first key-value pair before the first semicolon of each set-cookie response
header.

#### What goes after the first semicolon?

Metadata about the cookie

* when the client should expire the cookie
    + Cookie is deleted from the client
    + No longer sent with HTTP requests
* what domain the cookie is associated with
    + Important because we don't want cookies set by one domain to be sent to a
      different domain.

### State emulation

How are cookies used to emulate state?

HTTP requests are being sent, HTTP responses are being received.

* Cookies persist through multiple HTTP requests
    + Cookies store data from previous HTTP responses
* Cookies can expire
    + Clients can reset the initial "state" by destroying cookies

How do we validate cookies?
---------------------------

Is the existence of a key/value pair within a cookie enough information alone?

The value of the cookie needs to be persisted on the server to validate it.

This is done through sessions

Sessions
--------

Sessions are very similar to cookies in terms of structure and how you use them
(key/value pairs)

Cookies store information on the client
Session information is stored on the server

BUT we need some way to correlate a client to a session.
* If the session is stored on the server, then it's not stored on the client,
  then there's no way for the client to identify itself

### Example session:

sessions = [
    15234263 => [
        "username": "Joe",
        "login_date": "Sep 25, 2015",
    ],
    15234263 => [
        "username": "Nick",
        "login_date": "Sep 24, 2015",
    ],
]

How can we use the session id to link the client to the correct session?

Use cookies. How?

Use a set-cookie to link the session id with the client.

Example:

    set-cookie: SESSIONID=15234263;

Then for requests, you would send the following header:

    cookie: SESSIONID=15234263;

Advantages:

* Potentially sensitive data is not stored on the client
* You can store session IDs in the database

Sessions have their own expiration, just like cookie.

Default strategy
----------------

Create a session on the server side, and then send back the session id in a
cookie. This way potentially private or exploitable information is not available
on the client.

(If a client's packets are sniffed, no valuable information can be gathered
other than the session id)

Assignment
----------

Create a diagram of how you would architect an authentication/session system so
that when a user visits www.myapp.com/profile their information is pulled up.

Use your knowledge of set-cookie, cookie, and sessions.

Assume the following tables exist on the database your app uses:

user table
+----+----------+----------+
| id | username | password |
+----+----------+----------+
|  2 | joequery | asoetn   |
|  3 | nicknick | oetnu    |
|  4 | calicali | lol      |
+----+----------+----------+

profile table
-----+----------+-------+------------+-----------+
| id | user_id  | email | first_name | last_name |
-----+----------+-------+------------+-----------+
|  2 | joequery | asoetn|        Joe | McCullough|
|  3 | nicknick | oetnu |       Nick |       Dunn|
|  4 | calicali | lol   |     Callie |    Briscoe|
-----+----------+-------+------------+-----------+
