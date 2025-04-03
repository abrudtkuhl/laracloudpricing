# Laravel Cloud Pricing Calculator

This is an open-source pricing calculator built with Laravel and Livewire to estimate potential costs on Laravel Cloud.

## How It's Made

This project started as a way to provide a clearer, interactive estimation of potential costs for hosting applications on Laravel Cloud. While Laravel Cloud offers powerful features, estimating the final monthly cost based on different configurations can sometimes be challenging using static pricing tables alone.

**Data Source:** All pricing information used in this calculator is based on the publicly available pricing details found on the official [Laravel Cloud website](https://laravel.com/cloud/pricing) at the time of the last update. *Please note that this is a community project and not an official Laravel tool. Prices are subject to change, and this calculator should be used for estimation purposes only.*

**Technology:** The calculator is built using:
*   **Laravel:** The underlying PHP framework.
*   **Livewire:** For creating dynamic, interactive UI components without writing much JavaScript.
*   **Livewire Flux:** A component library providing pre-built UI elements like inputs and dropdowns.
*   **Tailwind CSS:** For utility-first styling.
*   **Alpine.js:** For small sprinkles of client-side interactivity where needed.

The goal is to offer a helpful tool for the Laravel community to quickly explore different service combinations and get a ballpark figure for their potential hosting costs.

## Try it Live!

You can try out the live version of the calculator here:
[pricingcalculator-main-ibvtp5.laravel.cloud](https://pricingcalculator-main-ibvtp5.laravel.cloud)

## Features

*   Estimate costs based on application size, database type/size, and usage.
*   Built with the TALL stack (Tailwind CSS, Alpine.js, Laravel, Livewire).
*   Uses Livewire Flux components for the UI.
*   Provides a simple interface for understanding potential Laravel Cloud expenses.

## Running Locally (Development)

If you wish to run the calculator locally or contribute to its development:

1.  **Clone the repository:**
    ```bash
    git clone <repository-url>
    cd laracloudpricing
    ```

2.  **Install Dependencies:**
    ```bash
    composer install
    npm install
    ```

3.  **Setup Environment:**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
    *(Database configuration is not strictly necessary for the calculator to function.)*

4.  **Compile Assets & Run Server:**
    ```bash
    npm run dev &
    php artisan serve
    ```

5.  Visit `http://127.0.0.1:8000/pricing` in your browser.

## Contributing

Contributions are welcome! Please feel free to submit pull requests or open issues.

## License

This project is open-sourced software licensed under the [MIT license](LICENSE.md). (Note: You'll need to add a LICENSE.md file).

