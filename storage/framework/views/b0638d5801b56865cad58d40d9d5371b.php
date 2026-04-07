<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inscription Membre - PlayReserve</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

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
<body class="font-sans text-playtomic-text bg-white antialiased flex flex-col min-h-screen">

    <!-- Navbar -->
    <nav class="flex items-center justify-between px-6 lg:px-12 py-5 max-w-[1440px] mx-auto w-full border-b border-gray-100">
        <a href="<?php echo e(route('home')); ?>" class="flex items-center gap-2 text-playtomic-blue font-black text-xl tracking-wider uppercase">
            <i class="bi bi-layers h-6 text-2xl flex items-center"></i> PLAYRESERVE
        </a>
        <a href="<?php echo e(route('login')); ?>" class="text-sm font-bold text-gray-500 hover:text-playtomic-blue transition-colors">Log in instead</a>
    </nav>

    <!-- Content -->
    <main class="flex-1 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-playtomic-bg">
        <div class="max-w-md w-full bg-white p-10 rounded-[32px] shadow-xl border border-gray-100">
            
            <div class="text-center mb-8">
                <h2 class="text-[32px] font-black text-playtomic-text">Create Account</h2>
                <p class="mt-2 text-[15px] font-medium text-gray-500">Join the community and start playing.</p>
            </div>

            <form method="POST" action="<?php echo e(route('register')); ?>" class="space-y-4">
                <?php echo csrf_field(); ?>
                
                <div>
                    <label class="block text-[12px] uppercase tracking-wide font-black text-gray-400 mb-1.5">Full Name</label>
                    <input name="name" type="text" required autofocus class="block w-full px-4 py-3 bg-[#f4f5f7] border-transparent text-playtomic-text rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-playtomic-blue font-medium" placeholder="John Doe">
                </div>

                <div>
                    <label class="block text-[12px] uppercase tracking-wide font-black text-gray-400 mb-1.5">Email Address</label>
                    <input name="email" type="email" required class="block w-full px-4 py-3 bg-[#f4f5f7] border-transparent text-playtomic-text rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-playtomic-blue font-medium" placeholder="you@example.com">
                </div>
                
                <div>
                    <label class="block text-[12px] uppercase tracking-wide font-black text-gray-400 mb-1.5">Phone Number</label>
                    <input name="phone" type="text" class="block w-full px-4 py-3 bg-[#f4f5f7] border-transparent text-playtomic-text rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-playtomic-blue font-medium" placeholder="+212 60000000">
                </div>

                <div>
                    <label class="block text-[12px] uppercase tracking-wide font-black text-gray-400 mb-1.5">Password</label>
                    <input name="password" type="password" required class="block w-full px-4 py-3 bg-[#f4f5f7] border-transparent text-playtomic-text rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-playtomic-blue font-medium" placeholder="••••••••">
                </div>
                
                <div>
                    <label class="block text-[12px] uppercase tracking-wide font-black text-gray-400 mb-1.5">Confirm Password</label>
                    <input name="password_confirmation" type="password" required class="block w-full px-4 py-3 bg-[#f4f5f7] border-transparent text-playtomic-text rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-playtomic-blue font-medium" placeholder="••••••••">
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full flex justify-center py-4 px-4 font-bold rounded-full text-white bg-playtomic-blue hover:bg-blue-700 transition-colors shadow-lg shadow-playtomic-blue/30 text-[15px]">
                        Sign up
                    </button>
                </div>
            </form>
        </div>
    </main>

</body>
</html><?php /**PATH C:\Users\Youcode\Desktop\playreserve\resources\views/auth/register.blade.php ENDPATH**/ ?>