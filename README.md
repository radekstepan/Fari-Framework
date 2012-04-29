A lean PHP Model-View-Presenter Framework (2009 - 2010)

## About:

The core framework is very lean (596 lines of code) but still features a loosely coupled template for your projects, automatically filtering user input from forms, providing user authentication, database abstraction layer with field validation, design by contracts, unit testing and showing highlighted syntax in diagnostics class when things go wrong.

The extremely well-commented source code puts Fari Framework among the best 10% of all PHP projects on Ohloh.

## History:

This project started out as a backend for a CMS developed as part of a BSc. dissertation project. It has later been improved when porting 37Signals' Campfire into PHP.

### Documentation:

The API for the core framework is published on [GitHub Pages](http://radekstepan.github.com/Fari-Framework/package-Fari.html).

## Examples:

### Model:

```php
<?php

class Albums extends Table {

  /** @var string name of the db table */
  public $tableName = 'albums';

  /** @var array validates the presence of column data */
  public $validatesPresenceOf = array('artist', 'title');

  /** @var array validates the length of columns */
  public $validatesLengthOf = array(array('artist' => 2));

}
```

### Presenter:

```php
<?php

/** ... */

public function actionAdd() {
  if ($this->request->isPost()) {
    try {
      $this->albums->set(array(
        'artist' => $this->request->getPost('artist', 'html'),
        'title' => $this->request->getPost('title', 'html')
        ))->add();

      $this->flashSuccess = 'Album has been saved.';
      $this->redirectTo('/albums/');

    } catch (TableException $e) {
      $this->flashFail = $e->getMessage();
    }
  }

  $this->renderAction();
}

/** ... */
```
