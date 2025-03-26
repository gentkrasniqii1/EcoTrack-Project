public function register(Request $request) {
    $validated = $request->validate([
        'name' => 'required|string',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6'
    ]);

    $validated['password'] = bcrypt($validated['password']);
    $user = User::create($validated);

    return response()->json(['message' => 'User registered successfully', 'user' => $user]);
}
