<section class="p-6">
    <h2 class="text-2xl font-bold mb-4">Services</h2>
    <div class="grid md:grid-cols-2 gap-4">
        <?php
        $services = get_option('barbershop_services', []);
        foreach ($services as $service): ?>
            <div class="bg-white p-4 rounded-lg shadow-md flex flex-col items-center">
                <img src="<?php echo esc_url($service['image']); ?>" alt="<?php echo esc_attr($service['name']); ?>" class="w-full h-40 object-cover rounded-lg mb-2">
                <h3 class="text-lg font-bold"><?php echo esc_html($service['name']); ?></h3>
                <p class="text-gray-700"><?php echo esc_html($service['description']); ?></p>
                <p class="text-green-500 font-bold"><?php echo esc_html($service['price']); ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</section>
