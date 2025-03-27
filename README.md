# Job Board with Advanced Filtering

## Table Of Contents

- [About The Project](#about-the-project)
- [Features](#features)
- [Built With](#built-with)
- [API Documentation](#api-documentation)
- [API Usage Guide](#api-usage-guide)
- [Demo Video](#demo_video)
- [Getting Started](#getting-started)
  - [Prerequisites](#prerequisites)
  - [Installation](#installation)


## About The Project
This Laravel application manages job listings with complex filtering capabilities similar to Airtable. </br>
It supports various job types using an Entity-Attribute-Value (EAV) design pattern alongside traditional relational database models.

## Features

### 1. Basic Filtering by Field Type
- **Text/String fields** (title, description, company_name, etc.)  
  - Equality: `=` , `!=`  
  - Contains: `LIKE`
- **Numeric fields** (min_salary, max_salary, etc.)  
  - Equality: `=` , `!=`  
  - Comparison: `>`, `<`, `>=`, `<=`
- **Boolean fields** (is_remote, etc.)  
  - Equality: `=` , `!=`
- **Enum fields** (job_type, status, etc.)  
  - Equality: `=` , `!=`
- **Date fields** (published_at, created_at, etc.)  
  - Equality: `=` , `!=`  
  - Comparison: `>`, `<`, `>=`, `<=`

### 2. Relationship Filtering
- Filter by **languages** (e.g., jobs requiring PHP AND JavaScript)  
- Filter by **locations** (e.g., jobs in New York OR San Francisco)  
- Filter by **categories**  
- Operations supported:  
  - **HAS_ANY** → Job has any of the specified values
  - **IS_ANY** → Relationship matches any of the values

### 3. EAV Filtering by Attribute Type
- **Text attributes**  
  - Equality: `=` , `!=`  
  - Contains: `LIKE`
- **Number attributes**  
  - Equality: `=` , `!=`  
  - Comparison: `>`, `<`, `>=`, `<=`
- **Boolean attributes**  
  - Equality: `=` , `!=`
- **Select attributes**  
  - Equality: `=` , `!=`

### 4. Logical Operators
- Support for **AND/OR** logical operators.
- Support for **grouping conditions** using parentheses `()`.

## Built With
- **PHP**
- **Laravel**
- **PostgreSQL**

## API Documentation
<a href="https://documenter.getpostman.com/view/17672386/2sAYkLoHx3#848f3446-b49d-4804-8862-12fe79792e08" target="_blank"> API Docs [Postman] </a>

## API Usage Guide

### Basic Filtering
Use the format: `field operator value`  
- Example: `title="Frontend Developer"`
- Example: `min_salary >= 5000`

### Relationship Filtering
Use the format: `relationship operator [values]`  
- Example: `languages HAS_ANY [Go,PHP,JavaScript]`
- Example: `locations IS_ANY ["New York",Remote]`
- Example: `categories IS_ANY ["Software Development","Data Science"]`

### Attribute Filtering
Use the format: `attribute:attribute_name operator value`  
- Example: `attribute:years_experience <= 9`
- Example: `attribute:job_level = senior`

### Grouping Conditions
Use parentheses `()` to group conditions:  
```sql
(job_type="full-time" AND (languages HAS_ANY [PHP,JavaScript])) AND (locations IS_ANY ["New York",Remote]) AND attribute:years_experience>=3
```

## Example Filters
1. Find full-time jobs with PHP or JavaScript experience:
   ```sql
   job_type="full-time" AND languages HAS_ANY [PHP,JavaScript]
   ```
2. Find remote jobs with a minimum salary of $80,000:
   ```sql
   is_remote=true AND min_salary >= 80000
   ```
3. Find jobs in Berlin or London requiring Python:
   ```sql
   locations IS_ANY [Berlin,London] AND languages HAS_ANY [Python]
   ```
4. Find jobs published in the last 30 days:
   ```sql
   published_at >= "2024-02-25"
   ```
5. Find senior-level jobs requiring at least 5 years of experience:
   ```sql
   attribute:job_level = senior AND attribute:years_experience >= 5
   ```

## Database Diagram
![ERD](https://github.com/user-attachments/assets/9c0a6b58-0b55-4b4f-87e8-f5b477429ee7)


## Demo Video

## Getting Started

To get a local copy up and running follow these simple steps.

### Prerequisites

* PHP
* Composer
* Laravel
* PostgreSQL

### Installation
1.Create the Database

2.Clone the repo
  
  ```sh
      git clone https://github.com/MUSTAFA-Hamzawy/Job-Board-with-Advanced-Filtering.git
  ```

then, Move to the project directory

3. Make your own copy of the .env file
```sh
    cp .env.example .env
    DB_DATABASE: <DB-name>
    DB_USERNAME= <DB-username>
    DB_PASSWORD: <DB-Password>
```
4. Install dependecies

```sh
    composer install
```
5. Generate a key
```sh
    php artisan key:generate
```
6. Migration & seeders
```sh
    php artisan migrate
    php artisan db:seed
```
7. Start Running
```sh
    php artisan serve
```
