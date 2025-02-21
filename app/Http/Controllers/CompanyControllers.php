<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompanyControllers extends Controller
{
    protected function jsonResponse($data = null, $status = 200, $message = 'Success')
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    public function companies(Request $request)
    {
        try {
            $user = $request->user();
            if (!$user) {
                return $this->jsonResponse(null, 401, 'User not authenticated');
            }

            $companies = $user->companies()->paginate(10);
            return $this->jsonResponse($companies);
        } catch (\Exception $e) {
            return $this->jsonResponse(null, 500, 'An error occurred');
        }
    }
}


