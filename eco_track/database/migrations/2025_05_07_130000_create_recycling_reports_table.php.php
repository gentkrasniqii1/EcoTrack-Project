public function up()
{
    Schema::create('recycling_reports', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('type');
        $table->integer('amount');
        $table->timestamps();
    });
}
