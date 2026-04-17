<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PlayReserve - Find Courts and Players</title>

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
                            dark: '#121212',
                            gray: '#f5f5f5',
                            text: '#222222'
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        .hero-bg {
            background-color: #3461ff;
            background-image: 
                linear-gradient(115deg, transparent 40%, rgba(255,255,255,0.05) 41%, rgba(255,255,255,0.05) 60%, transparent 61%),
                linear-gradient(-65deg, transparent 60%, rgba(0,0,0,0.05) 61%, rgba(0,0,0,0.05) 80%, transparent 81%);
        }
        
        .image-clip {
            border-radius: 0;
            border-top-left-radius: 0;
            border-bottom-left-radius: 60%;
            border-top-right-radius: 120px;
            border-bottom-right-radius: 0;
        }

        .highlight-lime {
            background-color: #ccf600;
            padding: 0 4px;
            font-weight: 700;
            color: #121212;
        }
        
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        
        
        .squiggly-svg {
            position: absolute;
            bottom: -30px;
            left: 50%;
            transform: translateX(-50%);
            width: 120%;
            height: auto;
            pointer-events: none;
            color: #ccf600;
        }
    </style>
</head>
<body class="font-sans text-playtomic-text bg-white antialiased">

    <section class="hero-bg min-h-[650px] relative overflow-hidden flex flex-col pt-4">
        
        <nav class="relative z-20 flex items-center justify-between px-6 lg:px-12 max-w-[1440px] mx-auto w-full">
            <a href="<?php echo e(auth()->check() ? route('dashboard') : route('home')); ?>" class="flex items-center gap-2 text-white font-bold text-xl tracking-wider uppercase">
                <i class="bi bi-layers h-6 text-2xl flex items-center"></i> PLAYRESERVE
            </a>
            
            <div class="hidden lg:flex items-center gap-6 text-white font-bold text-[15px]">
                <?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(route('dashboard')); ?>" class="hover:opacity-80 transition-opacity">Dashboard</a>
                    <form method="POST" action="<?php echo e(route('logout')); ?>" class="inline">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="hover:opacity-80 transition-opacity font-bold">Log out</button>
                    </form>
                <?php else: ?>
                    <a href="<?php echo e(route('register.owner')); ?>" class="flex items-center gap-1.5 hover:opacity-80 transition-opacity whitespace-nowrap text-playtomic-lime">
                        <i class="bi bi-briefcase"></i> Become Owner
                    </a>
                    
                    <a href="<?php echo e(route('register')); ?>" class="hover:opacity-80 transition-opacity">Sign up</a>
                    
                    <a href="<?php echo e(route('login')); ?>" class="ml-2 flex items-center justify-center gap-2 bg-playtomic-lime text-black px-5 py-2.5 rounded-full font-bold hover:bg-playtomic-limedark transition-colors">
                        Login <i class="bi bi-box-arrow-in-right text-lg ml-1"></i>
                    </a>
                <?php endif; ?>
            </div>
        </nav>

        <div class="relative z-10 flex-1 max-w-[1440px] mx-auto w-full px-6 lg:px-12 flex flex-col lg:flex-row items-center justify-between pt-16 pb-20">
            
            <div class="w-full lg:w-[55%] pr-0 lg:pr-10 z-20">
                <h1 class="text-5xl lg:text-[76px] font-black leading-[1.05] text-white tracking-tight mb-8">
                    Find <span class="text-playtomic-lime italic pr-1">courts</span> <span class="text-playtomic-lime italic">and<br> players</span> near you
                </h1>
                
                <p class="text-white font-bold text-xl lg:text-2xl leading-snug mb-10 max-w-lg">
                    Find matches and courts for Football, Basketball, Volleyball and more.<br> Connect anytime, anywhere
                </p>
                
                <form action="<?php echo e(route('clubs.index')); ?>" method="GET" class="bg-white rounded-full p-2 pl-6 pr-2 mt-2 flex items-center shadow-xl w-full max-w-[550px] relative">
                    <svg class="w-6 h-6 text-gray-500 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <input type="text" name="name" placeholder="Rechercher un club par nom..." class="w-full py-4 bg-transparent border-none focus:outline-none focus:ring-0 text-[#222] placeholder-gray-500 font-medium text-lg">
                    <button type="submit" class="bg-playtomic-lime text-black rounded-full px-8 py-3 ml-2 font-black hover:bg-playtomic-limedark transition-colors shrink-0">
                        Chercher
                    </button>
                </form>
            </div>
            
            <div class="w-full lg:w-[45%] mt-16 lg:mt-0 relative hidden md:block z-10 h-[500px]">
                <div class="absolute right-0 top-0 w-[120%] h-[120%] image-clip overflow-hidden shadow-2xl bg-white">
                    <img src="<?php echo e(asset('images/padel-hero.png')); ?>" alt="Players" class="w-full h-full object-cover origin-center">
                </div>
            </div>
            
        </div>
    </section>

    <section class="py-24 bg-white overflow-hidden">
        <div class="max-w-[1240px] mx-auto px-6 lg:px-12 flex flex-col md:flex-row items-center gap-16 lg:gap-28">
            
            <div class="w-full md:w-1/2 relative flex justify-center">
                <div class="relative rounded-[32px] overflow-hidden w-full max-w-[420px] z-10 bg-gray-100 shadow-lg">
                    <img src="<?php echo e(asset('images/padel-info.png')); ?>" alt="Player" class="w-full h-[600px] object-cover">
                </div>
                <svg class="squiggly-svg z-20" viewBox="0 0 400 200" fill="none" xmlns="http://www.w3.org/2000/svg" style="transform: translateX(-40%) translateY(20px) rotate(-10deg);">
                    <path d="M50 180 L 150 50 L 250 180 L 350 80" stroke="currentColor" stroke-width="24" stroke-linecap="square" stroke-linejoin="miter" fill="none"/>
                </svg>
            </div>
            
            <div class="w-full md:w-1/2 lg:pr-12">
                <h2 class="text-4xl lg:text-[44px] font-black text-playtomic-text mb-8 tracking-tight">What is PlayReserve?</h2>
                
                <p class="text-[19px] text-gray-800 leading-relaxed mb-6 font-medium">
                    PlayReserve is the <span class="highlight-lime">world's leading App for multi-sport players and clubs.</span> We help you find courts for Football, Basketball, Volleyball, and more.
                </p>
                
                <p class="text-[19px] text-[#4a4a4a] leading-relaxed">
                    It's the place where players, clubs, and coaches come together to share the court, learn from each other, and enjoy the sport we all love. More than just an app, it's a community built around the joy of playing.
                </p>
            </div>
        </div>
    </section>

    <section class="py-20 bg-white">
        <div class="max-w-[1240px] mx-auto px-6 lg:px-12">
            
            <h2 class="text-3xl font-black text-[#0B1526] tracking-tight mb-10">Top searched clubs worldwide</h2>
            
            <div class="relative group/slider">
                
                <button id="slider-prev" class="absolute -left-6 top-[40%] -translate-y-1/2 w-12 h-12 bg-white rounded-full shadow-lg border border-gray-100 flex items-center justify-center text-playtomic-blue z-20 opacity-0 group-hover/slider:opacity-100 disabled:opacity-0 transition-opacity cursor-pointer">
                    <i class="bi bi-chevron-left text-xl"></i>
                </button>
                <button id="slider-next" class="absolute -right-6 top-[40%] -translate-y-1/2 w-12 h-12 bg-white rounded-full shadow-lg border border-gray-100 flex items-center justify-center text-playtomic-blue z-20 opacity-0 group-hover/slider:opacity-100 disabled:opacity-0 transition-opacity cursor-pointer">
                    <i class="bi bi-chevron-right text-xl"></i>
                </button>

                <div id="clubs-slider" class="flex gap-6 overflow-x-auto snap-x snap-mandatory scrollbar-hide pb-8 pt-2 px-2 -mx-2">
                
                <?php $__empty_1 = true; $__currentLoopData = $clubs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $club): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="w-full md:w-[calc(50%-12px)] lg:w-[calc(33.333%-16px)] shrink-0 snap-start bg-[#F8F9FB] border border-[#EAEDF1] rounded-[24px] overflow-hidden flex flex-col group relative shadow-sm hover:shadow-lg transition-all duration-300">
                    <div class="h-40 w-full relative bg-gray-100 overflow-hidden shrink-0 border-b border-[#EAEDF1]">
                        <?php if($club->cover_image): ?>
                            <img src="<?php echo e(Storage::url($club->cover_image)); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <?php else: ?>
                            <div class="w-full h-full bg-gradient-to-tr from-playtomic-blue/5 to-playtomic-lime/10 flex items-center justify-center">
                                <i class="bi bi-buildings text-[60px] text-playtomic-blue/10"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="p-8 pt-4 flex flex-col flex-1 relative">
                        <div class="w-16 h-16 rounded-2xl bg-white shadow-md border-2 border-white flex items-center justify-center text-playtomic-blue text-2xl mb-4 -mt-12 relative z-10 overflow-hidden">
                            <?php if($club->logo): ?>
                                <img src="<?php echo e(Storage::url($club->logo)); ?>" class="w-full h-full object-cover">
                            <?php else: ?>
                                <i class="bi bi-shop text-3xl"></i>
                            <?php endif; ?>
                        </div>
                        
                        <h3 class="text-2xl font-black text-[#0B1526] mb-2"><?php echo e($club->name); ?></h3>
                        
                        <ul class="flex flex-col gap-3 mb-8 mt-2">
                            <li class="flex items-start gap-3 text-[15px] text-[#4b5563]">
                                <i class="bi bi-geo-alt-fill text-playtomic-lime text-lg mt-0.5"></i>
                                <span><?php echo e($club->city); ?></span>
                            </li>
                            <li class="flex items-start gap-3 text-[15px] text-[#4b5563]">
                                <i class="bi bi-telephone-fill text-playtomic-lime text-lg mt-0.5"></i>
                                <span><?php echo e($club->phone); ?></span>
                            </li>
                            <li class="flex items-start gap-3 text-[14px] text-[#6b7280] leading-relaxed line-clamp-3">
                                <i class="bi bi-info-circle-fill text-gray-300 text-lg mt-0.5"></i>
                                <span><?php echo e(Str::limit($club->description, 90)); ?></span>
                            </li>
                        </ul>
                        
                        <div class="mt-auto pt-4 border-t border-gray-200">
                            <a href="<?php echo e(route('clubs.show', $club->id)); ?>" class="inline-flex items-center justify-center bg-playtomic-blue text-white px-6 py-3 rounded-full font-bold text-[15px] hover:bg-blue-700 transition-colors shadow-sm w-full gap-2">
                                View courts <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-span-full py-12 text-center text-gray-500">
                    <i class="bi bi-buildings text-4xl mb-3 block text-gray-300"></i>
                    No clubs available yet. Register a club to get started!
                </div>
                <?php endif; ?>

            </div>
            
            <div class="flex justify-center mt-12 gap-3">
                <div class="w-2.5 h-2.5 rounded-full bg-playtomic-blue"></div>
                <div class="w-2.5 h-2.5 rounded-full bg-[#E5E7EB]"></div>
                <div class="w-2.5 h-2.5 rounded-full bg-[#E5E7EB]"></div>
            </div>
            
        </div>
    </section>

    <footer class="bg-[#0B1526] text-white py-16">
        <div class="max-w-[1240px] mx-auto px-6 lg:px-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
                <div class="lg:col-span-1">
                    <a href="#" class="flex items-center gap-2 text-white font-black text-xl tracking-wider uppercase mb-6">
                        <i class="bi bi-layers h-6 text-2xl flex items-center text-playtomic-lime"></i> PLAYRESERVE
                    </a>
                    <p class="text-gray-400 text-sm leading-relaxed mb-6 font-medium">
                        Join the fastest-growing community of multi-sport players. Find courts for Football, Basketball, Volleyball and more.
                    </p>
                    <div class="flex gap-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center text-white hover:bg-playtomic-lime hover:text-black transition-colors"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center text-white hover:bg-playtomic-lime hover:text-black transition-colors"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center text-white hover:bg-playtomic-lime hover:text-black transition-colors"><i class="bi bi-facebook"></i></a>
                    </div>
                </div>

                <div>
                    <h4 class="text-white font-bold mb-6">PlayReserve</h4>
                    <ul class="space-y-4 text-sm text-gray-400 font-medium">
                        <li><a href="#" class="hover:text-white transition-colors">Download our app</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Work with us</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">About Us</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Contact</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-bold mb-6">For Partners</h4>
                    <ul class="space-y-4 text-sm text-gray-400 font-medium">
                        <li><a href="<?php echo e(route('register.owner')); ?>" class="hover:text-playtomic-lime transition-colors text-playtomic-lime font-bold">Add your club</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">PlayReserve Manager</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Pricing</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Academy</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-bold mb-6">Legal</h4>
                    <ul class="space-y-4 text-sm text-gray-400 font-medium">
                        <li><a href="#" class="hover:text-white transition-colors">Terms of Service</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Cookies Policy</a></li>
                    </ul>
                </div>
            </div>

            <div class="pt-8 border-t border-white/10 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-gray-400 text-sm font-medium">© <?php echo e(date('Y')); ?> PlayReserve. All rights reserved.</p>
                <div class="flex items-center gap-2 text-sm text-gray-400 font-medium">
                    Made with <i class="bi bi-heart-fill text-playtomic-lime"></i> for multi-sport lovers
                </div>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const slider = document.getElementById('clubs-slider');
            const prev = document.getElementById('slider-prev');
            const next = document.getElementById('slider-next');

            if(slider && prev && next) {
                const itemWidth = slider.querySelector('div.shrink-0')?.clientWidth || 300;
                const scrollAmount = itemWidth + 24; 

                prev.addEventListener('click', () => {
                    slider.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
                });
                
                next.addEventListener('click', () => {
                    slider.scrollBy({ left: scrollAmount, behavior: 'smooth' });
                });
                
                const updateButtons = () => {
                    prev.disabled = slider.scrollLeft <= 0;
                    next.disabled = slider.scrollLeft >= (slider.scrollWidth - slider.clientWidth - 5);
                };
                
                slider.addEventListener('scroll', updateButtons);
                window.addEventListener('resize', updateButtons);
                
                updateButtons();
                if (slider.scrollWidth <= slider.clientWidth) {
                    next.style.display = 'none';
                    prev.style.display = 'none';
                }
            }
        });
    </script>
</body>
</html>
<?php /**PATH C:\Users\Youcode\Desktop\playreserve\resources\views/welcome.blade.php ENDPATH**/ ?>