<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TempModel extends Model
{
protected $table = 'Master';

protected $primaryKey = 'sr_no';

protected $fillable = [
'sr_no',
'date',
'academic_year',
'session',
'alloted_category',
'voucher_type',
'voucher_no',
'roll_no',
'admin_no_or_unique_id',
'status',
'feecategory',
'faculty',
'program',
'department',
'batch',
'receipt_no',
'feehead',
'dueamount',
'paidamount',
'concession_amount',
'scholarship_amount',
'reverse_concession_amount',
'write_off_amount',
'adjusted_amount',
'refund_amount',
'fund_transfer_amount',
'remarks',
];

public $timestamps = false; // If your table doesn't have timestamps, set this to false.
}
