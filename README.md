# Cloud Book Writer

Cloud Book Writer is a skeleton application for the Laravel framework. This application helps authors manage and
structure their book content seamlessly.

## Requirements

- PHP ^8.1
- Composer
- Laravel ^10.10

## Installation

1. **Clone the Repository**:

```
git clone https://github.com/gacbaluyot/cloud-book-writer.git
```

2. **Change directory to the project's root folder**:

```
cd cloud-book-writer
```

4. **Install Dependencies**:

```
composer install
```

4. **Environment Setup**:

- Copy `.env.example` to `.env`:

```
cp .env.example .env
```

- Update `.env` with your database and other configuration details.

5. **Generate Application Key**:

```
php artisan key:generate
```

6. **Run Migrations and Seeders**:

```
php artisan migrate --seed
```

7. **Start the Development Server**:

Now, navigate to the displayed URL (usually `http://localhost:8000`) in your browser.

## Features

- Book Management: Add, edit, and organize book content.
- Collaborator Assignment: Assign roles to collaborators.
- Section Management: Structure your book's content in sections.

## Contributing

Contributions, issues, and feature requests are welcome! Please ensure to follow the standard pull request process and
ensure tests pass.
