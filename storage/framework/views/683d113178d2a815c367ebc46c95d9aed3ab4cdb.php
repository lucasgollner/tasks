

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Tasks</div>

                <div class="card-body">
                    
                    <?php if(count( $errors ) > 0): ?>
                        <div class="alert alert-danger col-xs-12" role="alert">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php echo e($error); ?>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endif; ?>

                    <?php if(Session::has('success')): ?>
                        <div class="alert alert-success col-xs-12" role="alert">
                            <?php echo e(Session::get('success')); ?>

                        </div>
                    <?php endif; ?>

                    <?php echo e(Form::open(array('route' => 'save','class' => 'form', 'method' => 'post'))); ?>

                            <?php echo e(Form::text('name',null, ["class"=>"form-control text-left", "placeholder"=>"Add new TASK"])); ?>

                            <?php echo e(Form::date('date',null, ["class"=>"form-control text-left"])); ?>

                            <?php echo e(Form::submit('save')); ?>

                    <?php echo e(Form::close()); ?>


                    <hr>

                    Hey <b><?php echo e(Auth::user()->name); ?></b>, this is your todo list for today:

                    <br>

                    <?php if(\App\tasks::where('user', Auth::id())->count() == 0): ?>
                        (empty)
                    <?php endif; ?>

                    <?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        - <a href="#subtask<?php echo e($k->id); ?>" data-toggle="modal" > <?php echo e($k->name); ?> </a> <br>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </div>
            </div>
        </div>
    </div>
</div>

<?php $__currentLoopData = \App\tasks::where('user', Auth::id())->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="modal fade" id="subtask<?php echo e($k->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">subtask</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                
            </div>
            <div class="modal-body" style="min-height: 450px;">
                    <?php echo e(Form::open(array('route' => 'savesubtask','class' => 'form', 'method' => 'post'))); ?>

                    <?php echo e(Form::text('idtask', $k->id, ["class"=>"form-control text-left"])); ?>

                    <?php echo e(Form::text('nametask', $k->name, ["class"=>"form-control text-left"])); ?>


                    <hr>

                            <?php echo e(Form::text('name',null, ["class"=>"form-control text-left", "placeholder"=>"Add new SubTASK"])); ?>

                            <?php echo e(Form::date('date',null, ["class"=>"form-control text-left"])); ?>

                            <?php echo e(Form::submit('save')); ?>

                    <?php echo e(Form::close()); ?>


                    <hr>

                    Subtasks: <br>

                    <?php if(\App\subtasks::where('idtasks', $k->id)->count() <= 0): ?>
                        (empty)
                    <?php endif; ?>

                    <?php $__currentLoopData = \App\subtasks::where('idtasks', $k->id)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $y): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            - <?php echo e($y->name); ?> <br>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>