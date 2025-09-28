@extends('layouts.front')

@section('title', 'Vòng quay may mắn')

@section('content')
<div class="container py-5">
    <h2 class="text-center mb-4">🎉 Vòng quay may mắn 🎉</h2>

    <div class="d-flex justify-content-center">
        <div class="wheel-container">
            <canvas id="wheelCanvas" width="400" height="400"></canvas>
            <button id="spinBtn" class="spin-btn">Quay ngay</button>
        </div>
    </div>

    <div id="resultBox" class="text-center mt-4" style="display: none;">
        <h4 class="fw-bold">Kết quả: <span id="prizeText"></span></h4>
    </div>
</div>

<style>
    .wheel-container {
        position: relative;
        width: 400px;
        height: 400px;
    }

    #wheelCanvas {
        border-radius: 50%;
        border: 6px solid #333;
        background: #fff;
    }

    .spin-btn {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        padding: 15px 30px;
        border-radius: 50%;
        border: none;
        background: #ff4757;
        color: white;
        font-weight: bold;
        cursor: pointer;
        transition: 0.3s;
    }

    .spin-btn:hover {
        background: #e84118;
    }
</style>

<script>
    const canvas = document.getElementById("wheelCanvas");
    const ctx = canvas.getContext("2d");
    const spinBtn = document.getElementById("spinBtn");
    const resultBox = document.getElementById("resultBox");
    const prizeText = document.getElementById("prizeText");

    // Các phần thưởng (phải khớp với controller)
    const prizes = [
        "Giảm 10%",
        "Giảm 20%",
        "Miễn phí ship",
        "Chúc bạn may mắn lần sau"
    ];

    const colors = ["#ffbe76", "#ff7979", "#badc58", "#f9ca24"];

    let arc = Math.PI * 2 / prizes.length;
    let startAngle = 0;
    let spinTimeout = null;
    let spinAngle = 0;
    let spinAngleDelta = 0;
    let spinning = false;

    function drawWheel() {
        for (let i = 0; i < prizes.length; i++) {
            const angle = startAngle + i * arc;
            ctx.fillStyle = colors[i % colors.length];
            ctx.beginPath();
            ctx.moveTo(200, 200);
            ctx.arc(200, 200, 200, angle, angle + arc, false);
            ctx.lineTo(200, 200);
            ctx.fill();

            // Text
            ctx.save();
            ctx.translate(200, 200);
            ctx.rotate(angle + arc / 2);
            ctx.fillStyle = "#000";
            ctx.font = "16px Arial";
            ctx.fillText(prizes[i], 80, 10);
            ctx.restore();
        }

        // Vẽ mũi tên
        ctx.fillStyle = "#e74c3c";
        ctx.beginPath();
        ctx.moveTo(200 - 20, 0);
        ctx.lineTo(200 + 20, 0);
        ctx.lineTo(200, 40);
        ctx.closePath();
        ctx.fill();
    }

    function rotateWheel() {
        spinAngle *= 0.97;
        if (spinAngle > 0.2) {
            startAngle += (spinAngle * Math.PI / 180);
            drawWheel();
            spinTimeout = requestAnimationFrame(rotateWheel);
        } else {
            cancelAnimationFrame(spinTimeout);
            spinning = false;

            // Gửi AJAX tới server
            fetch("{{ route('spin.play') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({})
            })
            .then(res => res.json())
            .then(data => {
                prizeText.innerText = data.prize;
                resultBox.style.display = "block";
            });
        }
    }

    spinBtn.addEventListener("click", () => {
        if (spinning) return;
        spinning = true;
        spinAngle = Math.floor(Math.random() * 3000) + 2000; // góc quay ngẫu nhiên
        rotateWheel();
    });

    drawWheel();
</script>
@endsection
