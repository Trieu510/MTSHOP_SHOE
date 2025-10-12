@extends('layouts.front')

@section('title', 'Vòng quay may mắn')

@section('content')
<div class="container py-5">
    <h2 class="text-center mb-4 display-5 fw-bold text-gradient">🎉 Vòng quay may mắn 🎉</h2>

    <div class="d-flex justify-content-center">
        <div class="wheel-container position-relative shadow-lg rounded-circle bg-white p-3">
            <canvas id="wheelCanvas" width="400" height="400"></canvas>
            <button id="spinBtn" class="spin-btn btn btn-gradient position-absolute top-50 start-50 translate-middle shadow">
                Quay ngay
            </button>
        </div>
    </div>

    <div id="resultBox" class="text-center mt-4" style="display: none;">
        <h4 class="fw-bold text-success">Kết quả: <span id="prizeText"></span></h4>
        <button id="copyBtn" class="btn btn-outline-primary mt-2" style="display:none;">
            📋 Sao chép mã
        </button>
    </div>
</div>

<style>
/* Gradient chữ tiêu đề */
.text-gradient {
    background: linear-gradient(90deg, #ff8a00, #e52e71);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

/* Bánh xe container */
.wheel-container {
    width: 420px;
    height: 420px;
    position: relative;
    transition: transform 0.3s ease-in-out;
}

/* Canvas bánh xe */
#wheelCanvas {
    border: 10px solid #444;
    border-radius: 50%;
    display: block;
    box-shadow: 0 6px 15px rgba(0,0,0,0.2);
    background: radial-gradient(circle, #fff 0%, #f3f3f3 100%);
}

/* Nút quay */
.spin-btn {
    padding: 14px 28px;
    font-size: 18px;
    border-radius: 50px;
    z-index: 20;
    cursor: pointer;
    transition: transform 0.2s, box-shadow 0.2s;
}

.spin-btn:hover {
    transform: scale(1.08);
    box-shadow: 0 6px 20px rgba(0,0,0,0.3);
}

/* Gradient button */
.btn-gradient {
    background: linear-gradient(45deg, #ff4e50, #f9d423);
    color: #fff;
    border: none;
}

.btn-gradient:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

/* Kết quả */
#resultBox h4 {
    font-size: 1.5rem;
}

#copyBtn {
    transition: transform 0.2s, box-shadow 0.2s;
}

#copyBtn:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}
</style>

@php
    $prizeLabels = $coupons->map(fn($c) => $c->code)->toArray();
    $prizeLabels[] = "Chúc bạn may mắn lần sau";
@endphp

<script>
// --- Giữ nguyên toàn bộ logic JS ban đầu ---
const canvas = document.getElementById("wheelCanvas");
const ctx = canvas.getContext("2d");
const spinBtn = document.getElementById("spinBtn");
const resultBox = document.getElementById("resultBox");
const prizeText = document.getElementById("prizeText");
const copyBtn = document.getElementById("copyBtn");

const prizes = @json($prizeLabels);
const colors = ["#ffbe76","#ff7979","#badc58","#f9ca24","#7ed6df","#e056fd","#ffd166","#8ecae6"];

const centerX = canvas.width / 2;
const centerY = canvas.height / 2;
const radius = Math.min(centerX, centerY) - 4;
const textRadius = radius * 0.62;
const arc = (2 * Math.PI) / prizes.length;
let startAngle = 0;
let spinning = false;

function drawWheel() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    for (let i = 0; i < prizes.length; i++) {
        const angle = startAngle + i * arc;

        ctx.beginPath();
        ctx.moveTo(centerX, centerY);
        ctx.arc(centerX, centerY, radius, angle, angle + arc, false);
        ctx.closePath();

        // Gradient từng miếng
        const grad = ctx.createLinearGradient(centerX, centerY, centerX + radius * Math.cos(angle + arc/2), centerY + radius * Math.sin(angle + arc/2));
        grad.addColorStop(0, colors[i % colors.length]);
        grad.addColorStop(1, "#fff");
        ctx.fillStyle = grad;
        ctx.fill();

        ctx.strokeStyle = "#333";
        ctx.lineWidth = 2;
        ctx.stroke();

        ctx.save();
        ctx.translate(centerX, centerY);
        ctx.rotate(angle + arc / 2);
        ctx.fillStyle = "#111";
        ctx.font = "bold 16px Arial";
        ctx.textAlign = "center";
        ctx.textBaseline = "middle";
        ctx.fillText(prizes[i], textRadius, 0);
        ctx.restore();
    }

    ctx.beginPath();
    ctx.arc(centerX, centerY, radius + 2, 0, Math.PI * 2);
    ctx.lineWidth = 6;
    ctx.strokeStyle = "#2b2b2b";
    ctx.stroke();

    // Kim sáng nổi bật
    ctx.fillStyle = "#e74c3c";
    ctx.shadowColor = "#ff0000";
    ctx.shadowBlur = 8;
    ctx.beginPath();
    ctx.moveTo(centerX, centerY - radius - 6);
    ctx.lineTo(centerX - 16, centerY - radius + 22);
    ctx.lineTo(centerX + 16, centerY - radius + 22);
    ctx.closePath();
    ctx.fill();
    ctx.shadowBlur = 0; // reset shadow
}

function spinToIndex(index, callback) {
    const centerAngle = index * arc + arc / 2;
    const extraTurns = 5 + Math.floor(Math.random() * 3);
    const finalAngle = ( - Math.PI/2 - centerAngle ) + extraTurns * 2 * Math.PI;
    const duration = 4200;
    const start = performance.now();

    function animate(now) {
        const elapsed = now - start;
        const t = Math.min(elapsed / duration, 1);
        const ease = 1 - Math.pow(1 - t, 3);

        startAngle = finalAngle * ease;
        drawWheel();

        if (t < 1) {
            requestAnimationFrame(animate);
        } else {
            startAngle = finalAngle;
            drawWheel();
            callback();
        }
    }

    requestAnimationFrame(animate);
}

spinBtn.addEventListener("click", () => {
    if (spinning) return;
    spinning = true;
    spinBtn.disabled = true;

    fetch("{{ route('spin.play') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({})
    })
    .then(r => r.json())
    .then(data => {
        if (!data.success) {
            alert(data.message || "Có lỗi khi quay.");
            spinning = false;
            spinBtn.disabled = false;
            return;
        }

        const index = Number(data.index);
        if (isNaN(index) || index < 0 || index >= prizes.length) {
            alert("Lỗi index từ server.");
            spinning = false;
            spinBtn.disabled = false;
            return;
        }

        spinToIndex(index, () => {
            prizeText.innerText = data.prize;
            resultBox.style.display = "block";

            if (data.coupon) {
                copyBtn.style.display = "inline-block";
                copyBtn.onclick = () => {
                    navigator.clipboard.writeText(data.coupon).then(() => {
                        alert("Đã sao chép mã: " + data.coupon);
                    });
                };
            } else {
                copyBtn.style.display = "none";
            }

            spinning = false;
            spinBtn.disabled = false;
        });
    })
    .catch(err => {
        console.error(err);
        alert("Lỗi kết nối.");
        spinning = false;
        spinBtn.disabled = false;
    });
});

drawWheel();
</script>
@endsection
