

<?php $__env->startSection('title', 'Mes réservations'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12">
        <h1>Mes réservations</h1>
        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo e(session('error')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if($reservations->count() > 0): ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Terrain</th>
                            <th>Club</th>
                            <th>Date</th>
                            <th>Horaire</th>
                            <th>Prix</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $reservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $res): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($res->terrain->name); ?></td>
                            <td><?php echo e($res->terrain->club->name); ?></td>
                            <td><?php echo e(\Carbon\Carbon::parse($res->reservation_date)->format('d/m/Y')); ?></td>
                            <td><?php echo e($res->start_time); ?> - <?php echo e($res->end_time); ?></td>
                            <td><?php echo e(number_format($res->total_price, 2)); ?> DH</td>
                             <td>
                                <?php if($res->status == 'confirmed'): ?>
                                    <span class="badge bg-success">Confirmed</span>
                                <?php elseif($res->status == 'pending'): ?>
                                    <span class="badge bg-warning">Pending</span>
                                <?php elseif($res->status == 'cancelled'): ?>
                                    <span class="badge bg-danger">Cancelled</span>
                                <?php elseif($res->status == 'refunded'): ?>
                                    <span class="badge bg-info">Refunded</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if(in_array($res->status, ['confirmed', 'pending'])): ?>
                                    <?php
                                        $reservationDateTime = \Carbon\Carbon::parse($res->reservation_date)->setTimeFromTimeString($res->start_time);
                                        $canCancel = now()->diffInHours($reservationDateTime, false) >= 24;
                                    ?>

                                    <?php
                                        $reservationDateTime = \Carbon\Carbon::parse($res->reservation_date)->setTimeFromTimeString($res->start_time);
                                        $isTooLate = now()->diffInHours($reservationDateTime, false) < 24;
                                    ?>

                                    <form action="<?php echo e(route('reservations.cancel', $res->id)); ?>" method="POST" onsubmit="return confirm('Are you sure you want to cancel this reservation? Your payment will be refunded.')">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="btn btn-sm <?php echo e($isTooLate ? 'btn-outline-secondary' : 'btn-outline-danger'); ?> rounded-pill px-3 shadow-none">
                                            <i class="bi <?php echo e($isTooLate ? 'bi-lock' : 'bi-x-circle'); ?> me-1"></i> Cancel
                                        </button>
                                        <?php if($isTooLate): ?>
                                            <div class="text-[10px] text-gray-400 mt-1"><i class="bi bi-info-circle"></i> Less than 24h</div>
                                        <?php endif; ?>
                                    </form>
                                <?php elseif($res->status == 'cancelled' || $res->status == 'refunded'): ?>
                                    <span class="text-muted small italic opacity-75">Annulée</span>
                                <?php else: ?>
                                    <span class="text-muted small">-</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info">Vous n'avez aucune réservation.</div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Youcode\Desktop\playreserve\resources\views/reservations/history.blade.php ENDPATH**/ ?>