# CakePHP Feedback Plugin #

## About ##

Feedback is a [CakePHP][] plugin which makes it easy to add comments and star ratings
for any content. It is designed to be simple, both to deploy and integrate into your
existing applications. It doesn't require huge modifications of your application, or
any of your existing models.

Known issues:

- no spam filter for comments (yet!), except for a simple honeypot

## Installation ##

**Important**: Minimum requirements for this plugin: `CakePHP 2.2+`.

What you need:

- CakePHP 2.2+
- jQuery
- CakePHP [Goodies plugin][] (by Graham Weldon a.k.a. predominant)

The plugin also uses (included in the plugin):

- [RateIt][] (by gidon)
- [Polymorphic behavior][] (by Andy Dawson a.k.a. AD7six)

These instructions assume you're using git as your source control, so if you're not,
simply unload the plugins manually into your Plugin folder instead of initialising
them as git submodules.

Assuming you have the correct version of CakePHP and you also have jQuery, the next
step is to install the Goodies plugin as a submodule:

	git submodule add git://github.com/predominant/goodies.git Plugin/Goodies
	git submodule init
	git submodule update

Now do the same for the Feedback plugin. If you're using Git, you can run this
while in your app folder:

	git submodule add git://github.com/lecterror/cakephp-feedback-plugin.git Plugin/Feedback
	git submodule init
	git submodule update

Or visit <http://github.com/lecterror/cakephp-feedback-plugin> and download the
plugin manually to your `app/Plugin/Feedback/` folder.

Also, don't forget to activate both plugins in your application config (see [Installing a Plugin][]
in the CakePHP Cookbook).

Next, you need to create the database tables needed by the plugin:

	cake schema create --plugin Feedback

This will create `ratings` and `comments` tables in your database. No other changes are made.

## Usage ##

Obviously, you can use both comments and ratings or just one of them, so the instructions are separated
(althought they are pretty much the same).

### Comments ###

Let's pretend you have a model called Post, and you want to add comments to your posts. The first step
is to make your model `Commentable`:

	class Post extends AppModel
	{
		public $actsAs = array('Feedback.Commentable');
	}

The behaviour simply adds a hasMany relation (`Post hasMany Comment`) so you can get comments in
your views.

The next step is to include the Comments component in your controller. The component prepares some data
for the CommentsHelper. Comments helper is automatically included if it's missing, but you can add it
manually if you prefer that.

	class PostsController extends AppController
	{
		public $components = array('Feedback.Comments' => array('on' => array('admin_view', 'view'))),
	}

The component accepts the 'on' parameter, which contains actions when comments will be displayed.
Under the hood, this simply means that the Comments helper will not be loaded unless it's needed,
not will the component read the commenter cookie info.

Finally, display the comments in your view:

	<?php echo $this->Comments->display_for($post); ?>

The `display_for()` method takes two parameters. The first is the data containing both the parent row
(in this case the `Post` row), and all the comments for that row (if there are any). The second param
accepts the following options:

- model: The plugin tries to detect which model to use, but if it fails for some reason, you can try
to override it by giving it a model name.
- showForm: Automatically show comment form after the comments, set to `false` to disable.

If you set the showForm to false, you can display the form manually with the helper's `form()` method.

### Ratings ###

The use of ratings is pretty much the same as that of comments, so if you skipped that and something
isn't working, read that as well.

The Rated behaviour:

	class Post extends AppModel
	{
		public $actsAs = array('Feedback.Rated');
	}

The Ratings component:

	class PostsController extends AppController
	{
		public $components = array('Feedback.Ratings' => array('on' => array('admin_view', 'view'))),
	}	

The helper:

	<?php echo $this->Ratings->display_for($post); ?>

The difference in options is that the `display_for()` second param can override two options:

- model: If the model detection fails, you can override it here, _but_ it is necessary to include
the plugin name if the model is a part of a plugin, i.e. `Blog.Post`.
- modelClass: Model name without the plugin path, i.e. `Post`.

Normally, these things will be detected automatically.

Last, but not least, ratings require one last bit of code in your layout (or, if you prefer,
in your view), a call to output the script for the actual submission of ratings:

	<?php echo $this->fetch('script_execute'); ?>

This is normally placed before the closing `</body>` tag.

## Contributing ##

If you'd like to contribute, clone the source on GitHub, make your changes and send me a pull request.
If possible, always include unit tests for your modifications. If you're reporting a bug, a failing
unit test might help resolve the issue much faster than usual. If you don't know how to fix the issue
or you're too lazy to do it, create a ticket and we'll see what happens next.

I am always open to new ideas and suggestions.

**Important**: If you're sending a patch, follow the coding style! If you don't, there is a great
chance I won't accept it. For example:

	// bad
	function drink() {
		return false;
	}

	// good
	function drink()
	{
		return true;
	}

## Licence ##

Multi-licenced under:

* MPL <http://www.mozilla.org/MPL/MPL-1.1.html>
* LGPL <http://www.gnu.org/licenses/lgpl.html>
* GPL <http://www.gnu.org/licenses/gpl.html>

[CakePHP]: http://cakephp.org/
[Goodies plugin]: https://github.com/predominant/goodies
[RateIt]: http://rateit.codeplex.com/
[Polymorphic behavior]: http://bakery.cakephp.org/articles/AD7six/2008/03/13/polymorphic-behavior
[Naive Bayes Classifier]: http://en.wikipedia.org/wiki/Naive_Bayes_classifier
[Installing a plugin]: http://book.cakephp.org/2.0/en/plugins.html#installing-a-plugin
