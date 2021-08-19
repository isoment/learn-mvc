<div class="flex justify-center mt-12 font-mono">
	<div class="w-full max-w-sm">
		<h1 class="text-2xl font-bold text-gray-800 mb-3">Register</h1>

		<?php $form = \app\core\form\Form::begin('', 'post', 'bg-white shadow-md border rounded px-8 pt-6 pb-8 mb-4') ?>

			<?php echo $form->field($model, 'firstName') ?>
			<?php echo $form->field($model, 'lastName') ?>
			<?php echo $form->field($model, 'email') ?>
			<?php echo $form->field($model, 'password')->passwordField() ?>
			<?php echo $form->field($model, 'passwordConfirm')->passwordField() ?>

			<div class="flex justify-center">
				<button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 
							   rounded focus:outline-none focus:shadow-outline" 
						type="submit">
					Register
				</button>
			</div>

		<?php \app\core\form\Form::end() ?>

		<p class="text-center text-gray-500 text-xs">
			Simple MVC.
		</p>

	</div>
</div>