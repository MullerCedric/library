<?php /* METHOD / resource (controller name) / action (method name) */
return [
    /* USER */
    'signUp' => 'GET/user/signUp',
    'signedUp' => 'POST/user/signedUp',
    'logIn' => 'GET/user/logIn',
    'loggedIn' => 'POST/user/loggedIn',
    'loggedOut' => 'GET/user/loggedOut',
    /*'block' => 'POST/user/block',
    'profile' => 'GET/user/profile',*/

    /* AUTHORS */
    'authors' => 'GET/authors/list',
    'author' => 'GET/authors/zoom',
    'addAuthor' => 'GET/authors/add',
    'addedAuthor' => 'POST/authors/added',
    /*'editAuthor' => 'GET/authors/edit',
    'editedAuthor' => 'POST/authors/edited',*/

    /* BOOKS */
    'books' => 'GET/books/list',
    'book' => 'GET/books/zoom',
    'addBook' => 'GET/books/add',
    'addedBook' => 'POST/books/added',
    'addVersion' => 'GET/books/addVersion',
    'addedVersion' => 'POST/books/addedVersion',
    'addedCopy' => 'GET/books/addedCopy',
    'editBook' => 'GET/books/edit',
    'editedBook' => 'POST/books/edited',
    'deleteBook' => 'GET/books/delete',

    /* COMMENTS
    'addedComment' => 'POST/comments/added',
    'editComment' => 'GET/comments/edit',
    'editedComment' => 'POST/comments/edited',
    'moderateComments' => 'GET/comments/moderate', */

    /* BORROWINGS */
    'borrowings' => 'GET/borrowings/list',
    'addedBorrowing' => 'GET/borrowings/added',

    /* GENRES */
    'genres' => 'GET/genres/list',
    'addGenre' => 'GET/genres/add',
    'addedGenre' => 'POST/genres/added',

    /* SUBSCRIPTIONS */
    'addSubscription' => 'GET/subscriptions/add',
    'addedSubscription' => 'POST/subscriptions/added',

    /* SEARCH */
    'find' => 'GET/search/find',

    /* PAGES */
    'default' => 'GET/page/index',
    'dashboard' => 'GET/page/dashboard',
];
