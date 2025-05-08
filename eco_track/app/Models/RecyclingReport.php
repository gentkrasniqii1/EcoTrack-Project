class RecyclingReport extends Model
{
    protected $fillable = ['user_id', 'type', 'amount', 'location'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
