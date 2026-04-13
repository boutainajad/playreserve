<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Owner Registration - PlayReserve</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        playtomic: {
                            blue: '#3461ff',
                            lime: '#ccf600',
                            bg: '#f8f9fb',
                            text: '#222222'
                        }
                    },
                    fontFamily: { sans: ['Inter', 'sans-serif'] }
                }
            }
        }
    </script>
</head>
<body class="font-sans text-playtomic-text bg-playtomic-bg antialiased flex flex-col min-h-screen">

    <nav class="bg-white flex items-center justify-between px-6 lg:px-12 py-5 w-full border-b border-gray-100 shadow-sm sticky top-0 z-50">
        <div class="max-w-[1000px] mx-auto w-full flex items-center justify-between">
            <a href="<?php echo e(route('home')); ?>" class="flex items-center gap-2 text-playtomic-blue font-black text-xl tracking-wider uppercase">
                <i class="bi bi-layers h-6 text-2xl flex items-center"></i> PLAYRESERVE
            </a>
            <a href="<?php echo e(route('login')); ?>" class="text-sm font-bold text-gray-500 hover:text-playtomic-blue transition-colors">Log in instead</a>
        </div>
    </nav>

    <main class="flex-1 flex justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl w-full bg-white p-8 md:p-12 rounded-[32px] shadow-xl border border-gray-100 h-fit">
            
            <div class="text-center mb-10">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-playtomic-blue/10 text-playtomic-blue mb-4">
                    <i class="bi bi-briefcase-fill text-3xl"></i>
                </div>
                <h2 class="text-[32px] font-black text-playtomic-text">Register your Club</h2>
                <p class="mt-2 text-[15px] font-medium text-gray-500">Create your owner account and start receiving bookings.</p>
            </div>

            <?php if($errors->any()): ?>
                <div class="mb-8 p-4 bg-red-50 border border-red-100 rounded-xl">
                    <ul class="text-sm text-red-600 list-disc list-inside font-medium">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('register.owner')); ?>" enctype="multipart/form-data" class="space-y-8">
                <?php echo csrf_field(); ?>
                
                <div class="space-y-5">
                    <h3 class="text-lg font-bold text-playtomic-text border-b border-gray-100 pb-2">Personal Details</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-[12px] uppercase tracking-wide font-black text-gray-400 mb-1.5">Full Name *</label>
                            <input name="name" type="text" value="<?php echo e(old('name')); ?>" required class="block w-full px-4 py-3 bg-[#f4f5f7] border-transparent text-playtomic-text rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-playtomic-blue font-medium" placeholder="John Doe">
                        </div>
                        <div>
                            <label class="block text-[12px] uppercase tracking-wide font-black text-gray-400 mb-1.5">Email Address *</label>
                            <input name="email" type="email" value="<?php echo e(old('email')); ?>" required class="block w-full px-4 py-3 bg-[#f4f5f7] border-transparent text-playtomic-text rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-playtomic-blue font-medium" placeholder="you@example.com">
                        </div>
                        <div>
                            <label class="block text-[12px] uppercase tracking-wide font-black text-gray-400 mb-1.5">Phone Number</label>
                            <input name="phone" type="text" value="<?php echo e(old('phone')); ?>" class="block w-full px-4 py-3 bg-[#f4f5f7] border-transparent text-playtomic-text rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-playtomic-blue font-medium" placeholder="06XXXXXXXX">
                        </div>
                        <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-[12px] uppercase tracking-wide font-black text-gray-400 mb-1.5">Password *</label>
                                <input name="password" type="password" required class="block w-full px-4 py-3 bg-[#f4f5f7] border-transparent text-playtomic-text rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-playtomic-blue font-medium" placeholder="••••••••">
                            </div>
                            <div>
                                <label class="block text-[12px] uppercase tracking-wide font-black text-gray-400 mb-1.5">Confirm Password *</label>
                                <input name="password_confirmation" type="password" required class="block w-full px-4 py-3 bg-[#f4f5f7] border-transparent text-playtomic-text rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-playtomic-blue font-medium" placeholder="••••••••">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-5 pt-2">
                    <h3 class="text-lg font-bold text-playtomic-text border-b border-gray-100 pb-2">Club Information</h3>
                    
                    <div>
                        <label class="block text-[12px] uppercase tracking-wide font-black text-gray-400 mb-1.5">Club Name *</label>
                        <input name="club_name" type="text" value="<?php echo e(old('club_name')); ?>" required class="block w-full px-4 py-3 bg-[#f4f5f7] border-transparent text-playtomic-text rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-playtomic-blue font-medium" placeholder="e.g. Sport Center">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-[12px] uppercase tracking-wide font-black text-gray-400 mb-1.5">City *</label>
                            <select name="club_city" required class="block w-full px-4 py-3 bg-[#f4f5f7] border-transparent text-playtomic-text rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-playtomic-blue font-medium appearance-none">
                                <option value="">-- Select a city --</option>
                                <option value="Casablanca" <?php echo e(old('club_city') == 'Casablanca' ? 'selected' : ''); ?>>Casablanca</option>
                                <option value="Rabat" <?php echo e(old('club_city') == 'Rabat' ? 'selected' : ''); ?>>Rabat</option>
                                <option value="Marrakech" <?php echo e(old('club_city') == 'Marrakech' ? 'selected' : ''); ?>>Marrakech</option>
                                <option value="Fès" <?php echo e(old('club_city') == 'Fès' ? 'selected' : ''); ?>>Fès</option>
                                <option value="Tanger" <?php echo e(old('club_city') == 'Tanger' ? 'selected' : ''); ?>>Tanger</option>
                                <option value="Agadir" <?php echo e(old('club_city') == 'Agadir' ? 'selected' : ''); ?>>Agadir</option>
                                <option value="Meknès" <?php echo e(old('club_city') == 'Meknès' ? 'selected' : ''); ?>>Meknès</option>
                                <option value="Oujda" <?php echo e(old('club_city') == 'Oujda' ? 'selected' : ''); ?>>Oujda</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[12px] uppercase tracking-wide font-black text-gray-400 mb-1.5">Club Phone *</label>
                            <input name="club_phone" type="text" value="<?php echo e(old('club_phone')); ?>" required class="block w-full px-4 py-3 bg-[#f4f5f7] border-transparent text-playtomic-text rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-playtomic-blue font-medium" placeholder="05XXXXXXXX">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-[12px] uppercase tracking-wide font-black text-gray-400 mb-1.5">Club Address *</label>
                            <input name="club_address" type="text" value="<?php echo e(old('club_address')); ?>" required class="block w-full px-4 py-3 bg-[#f4f5f7] border-transparent text-playtomic-text rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-playtomic-blue font-medium" placeholder="123 Boulevard Mohammed V">
                        </div>
                        <div>
                            <label class="block text-[12px] uppercase tracking-wide font-black text-gray-400 mb-1.5">Club Email *</label>
                            <input name="club_email" type="email" value="<?php echo e(old('club_email')); ?>" required class="block w-full px-4 py-3 bg-[#f4f5f7] border-transparent text-playtomic-text rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-playtomic-blue font-medium" placeholder="contact@club.com">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[12px] uppercase tracking-wide font-black text-gray-400 mb-1.5">Club Description</label>
                        <textarea name="club_description" rows="3" class="block w-full px-4 py-3 bg-[#f4f5f7] border-transparent text-playtomic-text rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-playtomic-blue font-medium" placeholder="Describe your club..."><?php echo e(old('club_description')); ?></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                        <div>
                            <label class="block text-[12px] uppercase tracking-wide font-black text-gray-400 mb-1.5">Club Logo (Optional)</label>
                            <input name="club_logo" type="file" accept="image/*" class="block w-full px-4 py-3 bg-[#f4f5f7] border-transparent text-playtomic-text rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-playtomic-blue font-medium text-sm">
                        </div>
                        <div>
                            <label class="block text-[12px] uppercase tracking-wide font-black text-gray-400 mb-1.5">Cover Image (Optional)</label>
                            <input name="club_cover_image" type="file" accept="image/*" class="block w-full px-4 py-3 bg-[#f4f5f7] border-transparent text-playtomic-text rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-playtomic-blue font-medium text-sm">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[12px] uppercase tracking-wide font-black text-gray-400 mb-1.5">Club Location on Map (Optional)</label>
                        <p class="text-xs text-gray-500 mb-2 font-medium">Click on the map to place a pin at your exact club location.</p>
                        <div id="registration_map" class="w-full h-[300px] rounded-xl border-2 border-gray-100 z-10"></div>
                        <input type="hidden" name="club_latitude" id="club_latitude">
                        <input type="hidden" name="club_longitude" id="club_longitude">
                    </div>
                </div>

                <div class="pt-6">
                    <button type="submit" class="w-full flex justify-center py-4 px-4 font-bold rounded-full text-white bg-playtomic-blue hover:bg-blue-700 transition-colors shadow-lg shadow-playtomic-blue/30 text-[15px]">
                        Register Club
                    </button>
                </div>
            </form>
            
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Default center of Morocco
            const defaultLat = 31.7917;
            const defaultLng = -7.0926;
            
            const map = L.map('registration_map').setView([defaultLat, defaultLng], 5);
            
            L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
                attribution: '&copy; OpenStreetMap contributors &copy; CARTO',
                maxZoom: 20
            }).addTo(map);

            let marker = null;

            map.on('click', function(e) {
                const lat = e.latlng.lat;
                const lng = e.latlng.lng;

                if (marker) {
                    marker.setLatLng(e.latlng);
                } else {
                    marker = L.marker(e.latlng).addTo(map);
                }

                document.getElementById('club_latitude').value = lat;
                document.getElementById('club_longitude').value = lng;
            });
        });
    </script>
</body>
</html><?php /**PATH C:\Users\Youcode\Desktop\playreserve\resources\views/auth/owner-register.blade.php ENDPATH**/ ?>