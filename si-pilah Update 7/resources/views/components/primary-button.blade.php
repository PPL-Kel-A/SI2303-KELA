<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-green-700 to-green-600 border border-transparent rounded-xl font-semibold text-sm text-white tracking-wide hover:from-green-800 hover:to-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 active:from-green-900 shadow-md hover:shadow-lg transition ease-in-out duration-200']) }}>
    {{ $slot }}
</button>
