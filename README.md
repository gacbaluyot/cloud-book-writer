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

## Frontend Setup

This project uses Vite for a better front-end development experience. Here's how to set it up:

1. **Install Node Dependencies**:
```
npm install
```

2. **Development**:
- To start the development server:
  ```
  npm run dev
  ```

3. **Production**:
- To build for production:
  ```
  npm run build
  ```

### Frontend Packages

- **Vite**: A build tool that aims to provide a faster and leaner development experience for modern web projects. [More about Vite](https://vitejs.dev/).
- **Bootstrap**: The world’s most popular front-end open-source toolkit. [More about Bootstrap](https://getbootstrap.com/).
- **axios**: A promise-based HTTP client for the browser and Node.js. [More about axios](https://axios-http.com/).
- **@popperjs/core**: Popper is a positioning engine; its purpose is to calculate the position of an element to make it possible to position it near a given reference element. [More about Popper.js](https://popper.js.org/).
- **sass**: Sass is the most mature, stable, and powerful professional grade CSS extension language in the world. [More about Sass](https://sass-lang.com/).


## Features

- Book Management: Add, edit, and organize book content.
- Collaborator Assignment: Assign roles to collaborators.
- Section Management: Structure your book's content in sections.

## Contributing

Contributions, issues, and feature requests are welcome! Please ensure to follow the standard pull request process and
ensure tests pass.


