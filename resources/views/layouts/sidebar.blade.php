<aside class="w-64 min-h-screen p-4 bg-gradient-to-b from-blue-700 via-blue-800 to-blue-900 shadow-xl">
    <h2 class="text-xl font-extrabold text-white mb-6 tracking-wide">Меню</h2>
    <ul class="space-y-3">
        <li>
            <a href="{{ route('dashboard') }}" class="block py-2 px-4 rounded-lg font-semibold text-white bg-blue-800 hover:bg-blue-600 transition shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-400">Dashboard</a>
        </li>
        <li>
            <a href="{{ route('product-categories.index') }}" class="block py-2 px-4 rounded-lg font-semibold text-white bg-blue-800 hover:bg-blue-600 transition shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-400">Категории</a>
        </li>
        <li>
            <a href="{{ route('material-category-links.index') }}" class="block py-2 px-4 rounded-lg font-semibold text-white bg-blue-800 hover:bg-blue-600 transition shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-400">Связи с материалами</a>
        </li>
        <li>
            <a href="{{ route('sliders.index') }}" class="block py-2 px-4 rounded-lg font-semibold text-white bg-blue-800 hover:bg-blue-600 transition shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-400">Слайдеры</a>
        </li>
        <li>
                        <a href="{{ route('pages.index') }}" class="block py-2 px-4 rounded-lg font-semibold text-white bg-blue-800 hover:bg-blue-600 transition shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-400">Страницы</a>
</li>
<li>            <a href="{{ route('orders.index') }}" class="block py-2 px-4 rounded-lg font-semibold text-white bg-blue-800 hover:bg-blue-600 transition shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-400">Заказы</a>

        </li>
        <li>
            <a href="{{ route('delivery-locations.index') }}" class="block py-2 px-4 rounded-lg font-semibold text-white bg-blue-800 hover:bg-blue-600 transition shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-400">Локации доставки</a>
        </li>
        <!-- Добавь другие пункты меню по необходимости -->
    </ul>
</aside>
