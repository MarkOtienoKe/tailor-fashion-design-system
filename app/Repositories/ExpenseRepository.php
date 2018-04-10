<?php

namespace App\Repositories;

use App\Expense;
use App\ExpenseCategory;
use App\ViewModels\ExpenseView;
use Yajra\Datatables\Datatables;


/**
 * Created by PhpStorm.
 * User: mark
 * Date: 26/01/2018
 * Time: 17:33
 */
class ExpenseRepository
{
    public static function getExpensesData()
    {
        try {
            $query = ExpenseView::select()
                ->where('expense_status', '=', 'ACTIVE');
            return Datatables::of($query)
                ->make(true);
        } catch (\Exception $e) {
            \Log::error('Exception while fetching all expenses data' . [$e]);

            return null;
        }

    }

    public static function getTotalExpenses()
    {
        try {
            $query = ExpenseView::sum('amount');

            return $query;
        } catch (\Exception $e) {
            \Log::error('Exception while getting total expenses = ' . [$e]);

            return null;
        }

    }

    public static function saveExpense($params)
    {
        unset($params['_token']);
        $params['added_by'] = 1;
        $params['modified_by'] = 1;
        $params['status'] = 'ACTIVE';
        try {
            $response = Expense::insert($params);

            return $response;

        } catch (\Exception $e) {
            \Log::error('Exception while saving expense' . [$e]);

            return null;
        }

    }

    public static function saveExpenseCategory($params)
    {
        unset($params['_token']);
        $params['added_by'] = 1;
        $params['modified_by'] = 1;
        $params['status'] = 'ACTIVE';
        try {
            $response = ExpenseCategory::insert($params);

            return $response;

        } catch (\Exception $e) {
            \Log::error('Exception while saving expense' . [$e]);

            return null;
        }

    }

    public static function getExpenseCategories()
    {

        try {
            $query = ExpenseCategory::where('status', '=', 'ACTIVE')
                ->get(['id', 'name']);
            if (empty($query)) {
                return null;
            }
            return $query->toArray();

        } catch (\Exception $e) {
            \Log::error('Exception while retrieving expense categories' . [$e]);

            return null;
        }

    }

    public static function deactivateExpense($id)
    {
        try {

            $expense = Expense::find($id);

            $expense->status = 'IN-ACTIVE';

            return $expense->save();

        } catch (\Exception $e) {
            \Log::error('Exception while deactivating expense = ' . [$e]);

            return null;
        }

    }

    public static function editExpense($request)
    {
        try {
            $params = [
                'amount' => $request['amount'],
                'expense_category_id' => $request['expense_category_id'],
                'description' => $request['description'],
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'modified_by' => 1
            ];
            return Expense::find($request['expense_id'])
                ->update($params);

        } catch (\Exception $e) {
            \Log::error('Exception while updating expense' . [$e]);

            return null;
        }

    }
}