<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - PlayReserve</title>

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
                            limedark: '#b8de00',
                            text: '#222222',
                            bg: '#f8f9fb'
                        }
                    },
                    fontFamily: { sans: ['Inter', 'sans-serif'] }
                }
            }
        }
    </script>
</head>
<body class="font-sans text-playtomic-text bg-white antialiased flex flex-col min-h-screen">

    <nav class="flex items-center justify-between px-6 lg:px-12 py-5 max-w-[1440px] mx-auto w-full border-b border-gray-100">
        <a href="<?php echo e(route('home')); ?>" class="flex items-center gap-2 text-playtomic-blue font-black text-xl tracking-wider uppercase">
            <i class="bi bi-layers h-6 text-2xl flex items-center"></i> PLAYRESERVE
        </a>
        <a href="<?php echo e(route('register')); ?>" class="text-sm font-bold text-gray-500 hover:text-playtomic-blue transition-colors">Sign up instead</a>
    </nav>

    <main class="flex-1 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-playtomic-bg">
        <div class="max-w-md w-full bg-white p-10 rounded-[32px] shadow-xl border border-gray-100 animate-fade-in-up">
            
            <div class="text-center mb-10">
                <h2 class="text-[32px] font-black text-playtomic-text tracking-tight">Welcome back</h2>
                <p class="mt-2 text-[15px] font-medium text-gray-500">Log in to book courts and play matches.</p>
            </div>

            <form method="POST" action="<?php echo e(route('login')); ?>" class="space-y-6">
                <?php echo csrf_field(); ?>
                
                <div>
                    <label class="block text-[13px] uppercase tracking-wide font-black text-gray-400 mb-2">Email Address</label>
                    <input name="email" type="email" required autofocus class="block w-full px-4 py-4 bg-[#f4f5f7] border-transparent text-playtomic-text rounded-2xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-playtomic-blue focus:border-transparent font-medium" placeholder="you@example.com">
                </div>

                <div>
                    <label class="block text-[13px] uppercase tracking-wide font-black text-gray-400 mb-2">Password</label>
                    <input name="password" type="password" required class="block w-full px-4 py-4 bg-[#f4f5f7] border-transparent text-playtomic-text rounded-2xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-playtomic-blue focus:border-transparent font-medium" placeholder="••••••••">
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full flex justify-center py-4 px-4 font-bold rounded-full text-white bg-playtomic-blue hover:bg-blue-700 focus:outline-none transition-colors shadow-lg shadow-playtomic-blue/30 text-[15px]">
                        Log in
                    </button>
                </div>
            </form>

            <div class="mt-8 text-center">
                <a href="<?php echo e(route('register.owner')); ?>" class="text-sm font-semibold text-playtomic-blue hover:underline">Register your club instead?</a>
            </div>
        </div>
    </main>

</body>
</html><?php /**PATH C:\Users\Youcode\Desktop\playreserve\resources\views/auth/login.blade.php ENDPATH**/ ?>