<section class="p-6 bg-white text-center">
    <h2 class="text-2xl font-bold mb-4">Contact Us</h2>
    <p><?php echo esc_html(get_option('barbershop_address', '123 Main St, City, Country')); ?></p>
    <iframe class="w-full h-64 rounded-lg shadow-lg" src="<?php echo esc_url(get_option('barbershop_map', 'https://maps.google.com/?q=123+Main+St')); ?>"></iframe>
</section>
