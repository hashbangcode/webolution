Webolution
==========

An experimental set of classes that attempts to put together an application that will evolve a webpage. This is intended
to be a test application that allows me to learn the techniques involved in genetic algorithms as well as how to to
put together a modern PHP application with composer. As a result things might change significantly without warning. 

I'm interested in finding out if anyone has looked at this code or has any suggestions for improvement. Please get in touch via the issue queue and let me know.

Demo
====

A demo application has been written in [Slim Framework 3](https://www.slimframework.com/) that shows each evolution type running as well as some extra test cases like color sorting. This can be seen in the /demo directory. The application also features a couple of interactive forms that allow individuals to be selected and fed into the next generation.

Structure
=========
The application is structured into different types of objects in order to ensure separate concerns.

Types
-----
The types classes take care of the data types at the core of the evolution process. At it's core a _Type_ class only cares about the data that it contains. _Type_ classes do not have functionliaty to perform mutations or calculate fitness metrics, this is the domain of Individual classes.

Individuals
-----------
_Individual_ classes provide mutation and fitness functionality for Type classes. Instead of extending the types they wrap them as a parameter. _Individual_ classes can be regarded as decorators of the _Type_ classes. Each _Type_ class maps to an _Individual_ class.

Populations
-----------
The _Population_ class provides a collection of _Individuals_.

Evolution
---------
An Evolution class is used to control the process of evolution. This ties together the _Population_, _Individual_ and _Type_ classes and controls each generation of _Population_ objects.
An _EvolutionStorage_ class has been created to allow larger number of _Individuals_ to be evolved at once using a database as a storage engine.


Types Detail
============
The following details each of the types and any interactions they have with other types.

Number
------
Defines a class that contains a number. The NumberType class can add or subtract from this number. It was created as a very simple initial type in order to test the functionality of the evolution process.

Text
----
Defines a class that contains a string. The class has functions to get or set the string.

Color
-----
Defines a class that contains information about a color. This is stored internally by the RGB value of the color.

Image
-----
This defines a 2 dimensional array that renders out into an image. The array consists of either “on” or “off” values, which are then used to create a grid of boxes in an image.

Element
-------
This represents a HTML element. The core property is the element type (div, p, strong etc) and one or more attributes. The attributes can be used to give the elements a class or id, although any attribute is allowed.
An _Element_ object can also contain one or more child _Element_ objects, which creates a hierarchical structure of _Elements_.

Unit
----
The Unit is an object that holds information about a measurement in CSS. This is represented by a number and a unit of measurement. So values like 10px, 10em, 10% can exist.
A special value of ‘auto’ can also be represented.

Style
-----
This defines an object that contains information about a CSS rule set against a single element. The class contains a selector property and an attributes property that combine together to form a CSS block.
 
Page
----
A Page brings together the _Style_ and _Element_ classes into a page structure. The use of the _Page_ class allows the basic HTML structure of a page to be static whilst the elements and styles within it can change.

The Evolution Process
=====================
The following describes how the process of evolution works for each generation.

Culling
-------
To start the evolution process a certain amount of the population is removed. The chances of an individual being removed are dependent of the fitness of the individual. Individuals with a high fitness are less likely to be removed.

Replicate
---------
The existing individuals in the population are then replicated to bring the population number back to a designated minimum. This means that the current population will contain the fittest individuals.

Mutate
------
The population is then randomly mutated. How the population is mutated is dependent on the type of object being used.
After the population has been through the mutation cycle the population can then go through a crossover cycle. This is where individuals are mixed together and their attributes are swapped.

Generate Statistics
-------------------
Any statistics for the population are then calculated.

Storage
-------
This action clones the population into an array to that it can be retrieved later. This is important when looking through the history of the popluation.



Next steps
==========
Some things that need to happen.

- Tidy up the code. Lots of missing comments and messy looking bits.
- The way in which the TextIndividual works out it's fitness is based on an external factor. As such it would be better to abstract that functionality out so that it's not just this class that has this functionality.
- Refactor the forms in the demo application. The forms are prime for abstraction into a form class or perhaps a Symfony form component.
- Use the decorator design pattern to render individuals instead of passing the render type as a string.
- Create a downloader that will allow the full page individuals to be exported as full web pages. This can probably take the form of a decorator or a different renderer type.
- Find a better way of creating and storing the statistics generated from the evolution process.
- Print out statistics in the demo application.
- Add better "random" strings to the HTML elements, perhaps even using a lorem ipsum generator or similar. The current random strings make things look very messy.

Future plans
============
Some future plans to improve the application.

- Add a dependency injection container to streamline the use of the application in other applications.
- Generate a family tree of individuals. Might need to add a uuid to Individuals.
- Performance testing and improvements.
- Group Individuals into "species" or "related types".
- Add graphs of statistics to the demo application.
