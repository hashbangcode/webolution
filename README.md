Webolution
==========

An experimental set of classes that attempts to put together an application that will evolve a webpage. This is intended
to be a test application that allows me to learn the techniques involved in genetic algorithms as well as how to to
put together a modern PHP application with composer. As a result things might change significantly without warning.


The following data structures are used here:

- Core "Type" classes that provide the data components.
- "Individual" classes that allow mutation and fitness testing of the core class data structures.
- "Population" classes that allow the Individual classes to be collected together. This involves sorting them, calculating their fitness and killing them. 
- A main "Evolution" class that allows the Populations to be evolved.


The following items have been implemented:
- Number evolution.
- Text evolution.
- Colour evolution.
- Image evolution.
- HTML Element evolution.
- Style evolution.
- Full page evolution.

An EvolutionStorage class has been created to allow larger number of Individuals to be evolved at once.

A demo application has been written in Slim Framework 3 that shows each evolution running. This can be seen in the /demo directory. The application also features a couple of interactive forms that allow individuals to be selected and fed into the next generation.

Next steps:
- Refactor the constructor in the Evolution classes to prevent them doing too much or accepting too many parameters.
- Standardize the Individual constructors to prevent them being specific to the type.
- Force the population statistics to be generated.
- Have a minimal fitness model for all types.
- Implement cross over. Start with something simple like numbers and work from there.
- Refactor the forms in the demo application. The forms are prime for abstraction into a form class.
- Create a downloader that will allow the full page individuals to be exported as full web pages. This can probably take the form of a decorator or a different renderer type.
- Use the decorator design pattern to render individuals instead of passing the render type as a string.
- Print out statistics in the demo application.

Future plans:
- Add a dependency injection container to streamline the use of the application in other applications.
- Generate a family tree of individuals. Might need to add a uuid to Individuals.
- Performance testing and improvements.
- Attempt to group Individuals into "species" or "related types".
- Add graphs of statistics to the demo application.