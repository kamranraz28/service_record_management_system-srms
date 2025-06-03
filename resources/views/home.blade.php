@extends('layouts.admin')

@section('title', 'ড্যাশবোর্ড')

@section('content')

<style>
    .dashboard-section {
        padding: 2rem;
        background: #f9f9f9;
    }

    .glass-card {
        backdrop-filter: blur(14px);
        background: rgba(255, 255, 255, 0.3);
        border-radius: 1rem;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.18);
        transition: all 0.3s ease;
        padding: 1rem;
    }

    .glass-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
    }

    .card-title {
        font-size: 1rem;
        font-weight: 600;
        color: #333;
    }

    .count-number {
        font-size: 2rem;
        font-weight: 800;
        color: #111;
    }

    .card-icon {
        font-size: 1.8rem;
        color: #555;
    }

    .card-body p {
        font-size: 0.85rem;
        color: #444;
    }
</style>

<div class="dashboard-section">
    <h2 class="mb-4 fw-bold animate__animated animate__fadeInDown">📈 সিস্টেম তথ্য</h2>
    <div class="row g-3">

        @php
            $cards = [
                ['title' => 'ব্যবহারকারী', 'count' => $data['userCount'], 'icon' => 'fas fa-user-shield'],
                ['title' => 'কর্মচারী', 'count' => $data['employeeCount'], 'icon' => 'fas fa-users'],
                ['title' => 'সর্বাধিক কর্মচারী নিবন্ধনকারী অফিস', 'count' => $data['topOffice']['count'] ?? 0, 'icon' => 'fas fa-building', 'subtitle' => $data['topOffice']['name_bn'] ?? 'তথ্য নেই'],
                ['title' => 'শিক্ষাগত রেকর্ড', 'count' => $data['educayionCount'], 'icon' => 'fas fa-graduation-cap'],
                ['title' => 'পেশাগত দক্ষতা', 'count' => $data['additionalProffesionalCount'], 'icon' => 'fas fa-briefcase'],
                ['title' => 'বর্তমান ঠিকানা', 'count' => $data['presentAddressCount'], 'icon' => 'fas fa-map-marker-alt'],
                ['title' => 'স্থায়ী ঠিকানা', 'count' => $data['permanentAddressCount'], 'icon' => 'fas fa-home'],
                ['title' => 'সরকারি কোয়ার্টারে বাস', 'count' => $data['govtQuarterAddressCount'], 'icon' => 'fas fa-home'],
                ['title' => 'কোয়ার্টারে বাস নয়', 'count' => $data['notinQuarterAddressCount'], 'icon' => 'fas fa-home'],
                ['title' => 'চাকরির ইতিহাস', 'count' => $data['jobHistoryCount'], 'icon' => 'fas fa-history'],
                ['title' => 'পদোন্নতি', 'count' => $data['promotionCount'], 'icon' => 'fas fa-level-up-alt'],
                ['title' => 'ছুটির রেকর্ড', 'count' => $data['LeaveRecordCount'], 'icon' => 'fas fa-calendar-alt'],
                ['title' => 'অপরাধমূলক মামলা', 'count' => $data['CriminalProsecutioneCount'], 'icon' => 'fas fa-gavel'],
            ];
        @endphp

        @foreach($cards as $index => $card)
            <div class="col-md-3">
                <div class="card glass-card animate__animated" style="animation-delay: {{ $index * 0.2 }}s">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <div class="card-title">{{ $card['title'] }}</div>
                                <div class="count-number" data-count="{{ $card['count'] }}">0</div>
                            </div>
                            <div><i class="{{ $card['icon'] }} card-icon"></i></div>
                        </div>
                        @if(isset($card['subtitle']))
                            <p class="mt-2">অফিস: {{ $card['subtitle'] }}</p>
                        @else
                            <p class="mt-2">মোট {{ $card['title'] }} রেকর্ড।</p>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach

    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const cards = document.querySelectorAll(".glass-card");
        const counters = document.querySelectorAll(".count-number");

        cards.forEach((card, index) => {
            setTimeout(() => {
                card.classList.add("animate__fadeInUp");
            }, index * 200);
        });

        counters.forEach((counter, index) => {
            setTimeout(() => {
                const updateCount = () => {
                    const target = +counter.getAttribute('data-count');
                    const count = +counter.innerText;
                    const increment = Math.ceil(target / 50);

                    if (count < target) {
                        counter.innerText = Math.min(target, count + increment);
                        setTimeout(updateCount, 25);
                    } else {
                        counter.innerText = target;
                    }
                };
                updateCount();
            }, index * 200 + 400);
        });
    });
</script>

@endsection
