<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-red-600 to-red-500 border border-transparent rounded-xl font-semibold text-sm text-white tracking-wide hover:from-red-700 hover:to-red-600 active:from-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 shadow-md hover:shadow-lg transition ease-in-out duration-200']) }}>
    {{ $slot }}
</button>
