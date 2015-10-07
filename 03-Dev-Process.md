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
