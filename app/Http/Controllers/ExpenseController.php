<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 15/03/2018
 * Time: 11:18
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use function response;
use App\Repositories\ExpenseRepository;

class ExpenseController extends Controller
{

    public function index()
    {
        return view('expenses.list');
    }

    public function getExpenseData()
    {
        return ExpenseRepository::getExpensesData();
    }

    public function saveExpense(Request $request)
    {
        $response = ExpenseRepository::saveExpense($request->all());

        if ($response == true) {
            return response()->json([
                'status' => 'success',
                'message' => 'expense successfully created.',
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Something Went wrong.Try Again.',
            ], 500);
        }
    }
    public function saveExpenseCategory(Request $request)
    {
        $response = ExpenseRepository::saveExpenseCategory($request->all());

        if ($response == true) {
            return response()->json([
                'status' => 'success',
                'message' => 'expense category successfully created.',
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Something Went wrong.Try Again.',
            ], 500);
        }
    }
    public function getExpenseCategories()
    {
        $response = ExpenseRepository::getExpenseCategories();

        return $response;
    }

    public function deactivateExpense(Request $request)
    {
        \Log::debug('the material de req', [$request->all()]);
        $response = ExpenseRepository::deactivateExpense($request['expense_id']);

        if ($response > 0) {

            return response()->json(['message' => 'success', 'status_code' => 200]);
        } else {

            return response()->json(['errors' => 'action failed', 'status_code' => 500]);

        }
    }

    public function editExpense(Request $request)
    {
        $this->validate($request, [
            'amount' => 'required',
        ]);

        $response = ExpenseRepository::editExpense($request->all());
        if ($response == true) {
            return response()->json([
                'status' => 'success',
                'message' => 'Expense successfully updated.',
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Something Went wrong.Try Again.',
            ], 500);
        }
    }


}