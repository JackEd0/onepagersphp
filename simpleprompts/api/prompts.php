<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$prompts = [
  [
    'id' => 1,
    'title' => 'Generate a Vue component',
    'instructions' => 'Create a new component for a user profile card.',
    'content' => 'Component should display user name, avatar, and a short bio.',
    'tags' => ['vue', 'frontend', 'component'],
    'favorite' => true,
  ],
  [
    'id' => 2,
    'title' => 'Write a SQL query',
    'instructions' => 'Select all users from the "users" table who have signed up in the last 30 days.',
    'content' => 'SELECT * FROM users WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY);',
    'tags' => ['sql', 'database', 'backend'],
    'favorite' => false,
  ],
  [
    'id' => 3,
    'title' => 'Explain a design pattern',
    'instructions' => 'Describe the Singleton design pattern and its use cases.',
    'content' => 'The Singleton pattern ensures that a class has only one instance and provides a global point of access to it.',
    'tags' => ['design-patterns', 'software-architecture'],
    'favorite' => true,
  ],
  [
    'id' => 4,
    'title' => 'CSS trick for centering',
    'instructions' => 'Horizontally and vertically center a div.',
    'content' => 'display: flex; justify-content: center; align-items: center;',
    'tags' => ['css', 'frontend'],
    'favorite' => false,
  ],
];

echo json_encode($prompts);