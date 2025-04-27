<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use App\Models\Landlord;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminViewController extends Controller
{
    // Remove the constructor with middleware
    // public function __construct()
    // {
    //     $this->middleware('role:admin');
    // }

    public function dashboard()
    {
        // Get counts for dashboard statistics
        $studentCount = Student::count();
        $landlordCount = Landlord::count();
        $pendingLandlordCount = Landlord::where('approval_status', 'pending')->count();
        $propertyCount = Property::count();
        
        return view('admin.dashboard', compact(
            'studentCount', 
            'landlordCount', 
            'pendingLandlordCount',
            'propertyCount'
        ));
    }
    
    public function pendingLandlords()
    {
        $pendingLandlords = Landlord::where('approval_status', 'pending')
            ->with('user')
            ->get();
            
        return view('admin.pending-landlords', compact('pendingLandlords'));
    }
    
    public function approveLandlord(Request $request, $id)
    {
        $landlord = Landlord::findOrFail($id);
        $landlord->approval_status = 'approved';
        $landlord->save();
        
        return redirect()->route('admin.pending-landlords')
            ->with('success', 'Landlord account has been approved successfully.');
    }
    
    public function rejectLandlord(Request $request, $id)
    {
        $landlord = Landlord::findOrFail($id);
        $landlord->approval_status = 'rejected';
        $landlord->save();
        
        return redirect()->route('admin.pending-landlords')
            ->with('success', 'Landlord account has been rejected.');
    }
    
    public function allLandlords()
    {
        $landlords = Landlord::with('user')->get();
        return view('admin.landlords', compact('landlords'));
    }
    
    public function allStudents()
    {
        $students = Student::with('user')->get();
        return view('admin.students', compact('students'));
    }
}