<div class="flex justify-center mt-12 font-mono">
	<div class="w-full max-w-sm">
		<h1 class="text-2xl font-bold text-gray-800 mb-3">Register</h1>
		<form class="bg-white shadow-md border rounded px-8 pt-6 pb-8 mb-4"
			  method="post">
			<div class="mb-4">
				<label class="block text-gray-700 text-sm font-bold mb-2" for="first-name">
					First Name
				</label>
				<input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight 
							  focus:outline-none focus:shadow-outline" 
					   name="firstName" type="text" placeholder="First name">
			</div>
            <div class="mb-4">
				<label class="block text-gray-700 text-sm font-bold mb-2" for="last-name">
					Last Name
				</label>
				<input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight 
							  focus:outline-none focus:shadow-outline" 
					   name="lastName" type="text" placeholder="Last name">
			</div>
			<div class="mb-4">
				<label class="block text-gray-700 text-sm font-bold mb-2" for="email">
					Email
				</label>
				<input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight 
							  focus:outline-none focus:shadow-outline" 
					   name="email" type="text" placeholder="Email">
			</div>
			<div class="mb-4">
				<label class="block text-gray-700 text-sm font-bold mb-2" for="password">
					Password
				</label>
				<input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight 
							  focus:outline-none focus:shadow-outline" 
					   name="password" type="password" placeholder="Password">
			</div>
            <div class="mb-4">
				<label class="block text-gray-700 text-sm font-bold mb-2" for="confirm-password">
					Confirm Password
				</label>
				<input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight 
							  focus:outline-none focus:shadow-outline" 
					   name="passwordConfirm" type="password" placeholder="Confirm password">
			</div>
			<div class="flex justify-center">
				<button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 
							   rounded focus:outline-none focus:shadow-outline" 
						type="submit">
					Register
				</button>
			</div>
		</form>
		<p class="text-center text-gray-500 text-xs">
			Simple MVC.
		</p>
	</div>
</div>