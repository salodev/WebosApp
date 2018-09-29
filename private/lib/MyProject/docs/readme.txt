MyProject is bootstrap for your application with WebOS.

Feel free to add classes as you need, but first take a few minutes to know some
guidelines.

THE APPLICATION
The MyProject\App class is provided to your project. The 'main()' method is where
you must provide code that will be called at application starting.

CREATING WINDOWS
under MyProject\Windows namespace you should create any Window, ever as subclass
of Webos\Visual\Window.

CREATING CONTROLS
Because you may need a custom control for your application, a special folder was
provided, under MyProject\Controls namepsace, with a simple bootstrap control
named simply Example.

CREATING MODELS OR DATA ACCESS CLASSES
For any data access you should put it under Model namespace.

ANOTHER ELSE
Add namespaces under src folder for anything you need.

===============================================================================
App Skeleton

Tree                   | Explanation
-----------------------+-------------------------------------------------------
root                   |
+--> private           |
|    +--> lib          | Location for all classes. Project Application, webos
|    |                 | libs, dependencies, etc.
|    +--> workspaces   | Where user 'sessions' is located in development mode.
|    +--> log          | Place for all log files.
|    +--> debug        | Drop here debug info.
+--> public            | Webserver root directory.

Code that you MUST add or modify for production mode.

File                   | Work
-----------------------+-------------------------------------------------------
private/start.php      | Look and modify 
                       | Implementation::$dev = true;
                       | by 
                       | Implementation::$dev = false;
                       | 
public/index.php       | Create a form that fill 'username' key
                       | into $_SESSION variable with a validated user.
                       |

Install webos-master service.


