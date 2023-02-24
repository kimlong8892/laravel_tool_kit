<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use PHPUnit\Exception;

class CouponController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View {
        $listCampaign = $this->campaignRepository->getList();

        return view('admin.campaign.index', compact('listCampaign'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View {
        return view('admin.campaign.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse {
        try {
            $campaignId = $this->campaignRepository->store($request->toArray());

            return redirect()->route('admin.campaigns.edit', $campaignId)->with('success', __('Create success', ['id' => $campaignId]));
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View {
        $campaign = $this->campaignRepository->getDetail($id);

        return view('admin.campaign.edit', compact('campaign'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse {
        try {
            $campaignId = $this->campaignRepository->update($id, $request->toArray());

            return redirect()->route('admin.campaigns.edit', $campaignId)->with('success', __('Update success', ['id' => $campaignId]));
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse {
        try {
            $this->campaignRepository->destroy($id);

            return redirect()->back()->with('success', __('Destroy success', ['id' => $id]));
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function updateInfoCampaignsAccesstrade(): RedirectResponse {
        try {
            if ($this->accesstradeApiRepository->insertCampaigns()) {
                return redirect()->back()->with('success', __('Update campaigns Accesstrade success'));
            }

            return redirect()->back()->with('success', __('Update campaigns Accesstrade error'));
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
}
