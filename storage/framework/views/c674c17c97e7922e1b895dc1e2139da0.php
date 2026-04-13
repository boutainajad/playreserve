<?php $__env->startSection('title', 'Mon Profil'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-3xl mx-auto">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black uppercase tracking-tight text-gray-900">Mon Profil</h1>
            <p class="text-gray-500 font-medium mt-1">Gérez vos informations personnelles et paramètres de compte.</p>
        </div>
    </div>

    <div class="bg-white rounded-[24px] shadow-sm border border-gray-100 p-8 mb-8 relative overflow-hidden">
        <!-- Decoration -->
        <div class="absolute -right-20 -top-20 w-64 h-64 bg-playtomic-lime/5 rounded-full blur-3xl z-0"></div>
        <div class="absolute -left-20 -bottom-20 w-64 h-64 bg-playtomic-blue/5 rounded-full blur-3xl z-0"></div>

        <div class="relative z-10">
            <h2 class="text-xl font-bold mb-6 text-gray-900 border-b border-gray-100 pb-4">Informations Personnelles</h2>
            
            <form action="<?php echo e(route('profile.update')); ?>" method="POST" class="space-y-6">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nom complet</label>
                        <input type="text" name="name" id="name" value="<?php echo e(old('name', $user->name)); ?>" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-playtomic-blue focus:border-playtomic-blue block p-3 font-medium transition-colors" required>
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-2 text-sm text-red-600 font-medium"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Adresse E-mail</label>
                        <input type="email" name="email" id="email" value="<?php echo e(old('email', $user->email)); ?>" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-playtomic-blue focus:border-playtomic-blue block p-3 font-medium transition-colors" required>
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-2 text-sm text-red-600 font-medium"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="phone" class="block text-sm font-bold text-gray-700 mb-2">Numéro de téléphone</label>
                        <input type="text" name="phone" id="phone" value="<?php echo e(old('phone', $user->phone)); ?>" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-playtomic-blue focus:border-playtomic-blue block p-3 font-medium transition-colors" placeholder="+212 6... (Optionnel)">
                        <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-2 text-sm text-red-600 font-medium"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-bold text-gray-700 mb-2">Adresse</label>
                        <input type="text" name="address" id="address" value="<?php echo e(old('address', $user->address)); ?>" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-playtomic-blue focus:border-playtomic-blue block p-3 font-medium transition-colors" placeholder="Ville, Quartier (Optionnel)">
                        <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-2 text-sm text-red-600 font-medium"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div class="pt-6 mt-6 border-t border-gray-100">
                    <h2 class="text-xl font-bold mb-6 text-gray-900 pb-2">Changer le mot de passe <span class="text-sm font-normal text-gray-500 ml-2">(Laisser vide pour ne pas changer)</span></h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="password" class="block text-sm font-bold text-gray-700 mb-2">Nouveau mot de passe</label>
                            <input type="password" name="password" id="password" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-playtomic-blue focus:border-playtomic-blue block p-3 font-medium transition-colors">
                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-2 text-sm text-red-600 font-medium"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-2">Confirmer le mot de passe</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-playtomic-blue focus:border-playtomic-blue block p-3 font-medium transition-colors">
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-4 pt-6 mt-6 border-t border-gray-100">
                    <a href="<?php echo e(url()->previous()); ?>" class="px-5 py-2.5 font-bold text-gray-500 hover:text-gray-900 transition-colors">Annuler</a>
                    <button type="submit" class="bg-playtomic-blue text-white px-8 py-2.5 rounded-full font-bold hover:bg-blue-700 transition-colors shadow-md shadow-playtomic-blue/20">
                        Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Youcode\Desktop\playreserve\resources\views/profile/edit.blade.php ENDPATH**/ ?>