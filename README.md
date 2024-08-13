# Blog API

## Overview

This is a simple RESTful API for a blog platform built using core PHP and MySQLi Procedural.

## Setup

1. **Database Setup**

   Run the following SQL commands to set up the database:

   ```sql
   CREATE DATABASE blogs;

   USE blogs;

   CREATE TABLE posts (
       id INT AUTO_INCREMENT PRIMARY KEY,
       title VARCHAR(255) NOT NULL,
       content TEXT NOT NULL,
       author VARCHAR(255) NOT NULL,
       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
       updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
   );```




2. **Directory Structure**
	Ensure your project directory has the following structure:



	blog-api/
	├── public/
	│   ├── api/
	│   │   ├── index.php
	│   └── .htaccess
	├── config/
	│   └── config.php
	├── controllers/
	│   └── PostController.php
	├── models/
	│   └── Post.php
	├── utils/
	│   └── Database.php
	└── README.md
	
2. **API ENDPOINT**
	Create a Post
		Endpoint: POST /api/posts
		DEMO: http://localhost/blog-api/public/api/posts
		
	
	Get All Posts
		Endpoint: GET /api/posts
		DEMO: http://localhost/blog-api/public/api/posts
			IF REQUIRED DATA WITH PAGINATION PASS QUERY STRING THE URL SHOULD BE LIKE THIS
		DEMO: http://localhost/blog-api/public/api/posts?page=1&limit=1
		
	Get a Single Post
		Endpoint: GET /api/posts/{id}
		DEMO: http://localhost/blog-api/public/api/posts/{ID}
		
	
	Update a Post
		Endpoint: PUT /api/posts/{id}
		DEMO: http://localhost/blog-api/public/api/posts/{ID}
		
	Delete a Post
		Endpoint: DELETE /api/posts/{id}
		DEMO: http://localhost/blog-api/public/api/posts/{ID}