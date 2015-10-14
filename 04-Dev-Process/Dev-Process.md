Dev Process
===========

Strategies for adding new functionality
---------------------------------------

* Create the structure before you create the logic
* Example, if you're wanting to implement a validation method,
  make a stupid version of that method, and make sure it's being called in the correct places.
  
### Thinking about inputs and outputs

* Keep your code in a working state as much as possible
* Introducing a new method shouldn't break the code. The method might now do what
  we want it to yet (And that's completely okay), but it still shouldn't break the code.
  Aim to have the project be useable and runnable at any point in time.
  
Validation:

  * Good / bad, yes / no
  * One of the conditions carries extra information, think in terms of "bad and not bad"
  * The way to design methods is to imagine you are going to use the method without
    knowing how it works. Pretend you will only know the inputs to the method and the
    return value of the method.
    
Strategy: If you want a method to return boolean yes/no, have the method name be of the
form of a yes/no question.

Examples:

  * `is_valid()`
  * `has_a_house()`
  * `is_stupid()`

Question to ask when creating a method:

* What are the method inputs?
* What is the method return value?
* How will the method return value be used?
* Where are we actually going to call this method?

Always have a way to test your code:

* Unit testing is great, but even if you're not unit testing, you should
  still always have a way to somehow test your code.

Error message debugging strategies:

* Draw as many conclusions you can from the error message.
* Remove yourself from the context of your project when examining the error message


Day 2 - Software Development processes
======================================

Nick's driving today!

Objectives
----------

* Validation method has been made, but it's not clean - let's clean it up
* We want to add validation to put

Adding validation to put
------------------------

### Altering other peopele's code

Rule #1 of altering people's code: Only change the behavior of code that is broken (unless you have thoroughly evaluated risk).
Even if the code itself has silly ideas, or is incorrect in some way that doesn't act as a major detriment to the project, adapt to its faults unless you have thoroughly evaluated the risk of change.

Example: An incorrect HTTP status code being returned on an error.

    public function putAction($slug, Request $request)
    {
        $response = new Response();
        $data = Bid::validatePut($request);
        if ($data) {
            if ($this->get('rest_service')->put('bid', $slug, $data))
            {
                $response->setStatusCode(200)->setContent('Succesfully updated record ' .$slug);
            } else {
                $response->setStatusCode(500)->setContent('Query failed');
            }
        } else {
            $response->setStatusCode(400)->setContent('Invalid request; expected Json with fields "userid", "houseid", "bidamount", "biddate"');
        }
        return $response;
    }
    
Observe the following line: 

    $response->setStatusCode(500)->setContent('Query failed');
    
The developer who wrote this source is using an incorrect HTTP status code to indicate failure. Processes rarely, if ever, should
return 500 level status codes. So technically, this 500 HTTP status code usage is against the opinions of conventional status codes.

HOWEVER - even though that status code is incorrect, it's not breaking anything. It's a misinformed opinion, or a slightly bad
decision, but it's not breaking anything. So when making adjustments to this code, even though we disagree with the decision
that was made, it's important to not change the behavior. Because there's probably other code that depends on that behavior right now.
There is probably some source, either on the JS side or on the server side, that looks for that 500 if the query is wrong.
And it's making decision based upon that. So we can't just change that number to fit our ideal way of thinking.

You have to ask yourself this question - is it better to be correct or better to have a working project?

### So when can you correct mistakes?

It's about risk/reward. Every change in a system introduces risk. You have to gauge whether the reward significantly outweighs the risk.

* Risk is signifantly decreased whenever products aren't in production. The prototyping phase is the place to make breaking changes and everyone's okay with it. It's the nature of prototyping.
* Once a system is in production, then the risk of every change goes up significantly.
    + It becomes your job to adapt to what's already there
    + you do the best that you can, but not the best you can't
* Refactoring is the practice of altering code while preserving the same responses (or results)
    * How you get there is different
    * But what you get back or what happens is the same
 
### Communication is key when refactoring code

* If you introduce a breaking change, you must warn people
    + A breaking change is any change that alters previous behavior
    + Another term this is introducing a change that's backwards incompatible - this version of the code is incompatible with previous version of the code
   
* Backwards compatibility - a measure of stability between different versions of a project

* If you're introducing backwards incompabitle changes, you have to warn the people that it may affect
    + If you change a function return value, any dev using that function has to know
    + If you change the JSON resulting from an API endpoint, you have to warn all devs using that API
        - They might rely on a key that you've renamed or deleted
        
        
Actually making the change!
---------------------------

Applying the bidErrors method to the PUT method for validation

Approach:

* POST is creating a new entry
* PUT is editing an existing entry
  + PUT needs an identifier - got it
  
* When altering code, make only 1 or 2 changes before testing to see if the desired behavior still occurs.
* Don't get too far in before you discover that a regression has been introduced.

### Assurance
If my change doesn't break the project, sometimes I like to intentionally break the project
just to make sure I'm editing the right file, looking at the right server, etc.

### Programming style

Your functions / methods should ONLY do what the name implies they will do. Otherwise
it can be confusing for other developers.

Objective accomplished - We incorporated our validation method into the putAction!

### Programming style

Functions / API endpoints should try to return the same data type whenever possible.

