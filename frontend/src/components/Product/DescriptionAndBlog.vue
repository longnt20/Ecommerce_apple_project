<template>
  <div class="product-wrapper">
    <!-- LEFT CONTENT -->
    <div class="left">
      <h2 class="title">Đặc điểm nổi bật của {{ product?.name }}</h2>

      <p class="desc">
        {{ product?.short_description }}
      </p>

      <button class="collapse-btn" @click="toggleContent">
        Nội dung chính
        <span :class="{ rotated: open }">⌄</span>
      </button>

      <!-- CKEditor description -->
      <div 
        class="content-section" 
        :class="{ collapsed: !expanded }" 
        ref="contentSection"
      >
        <div class="ck-content" v-html="product?.description"></div>
      </div>

      <!-- Xem thêm / Thu gọn -->
      <button 
        v-if="showToggle" 
        class="more-btn" 
        @click="toggleExpanded"
      >
        {{ expanded ? "Thu gọn" : "Xem thêm" }}
      </button>
</div>
    <!-- RIGHT SIDEBAR -->
    <div class="right" ref="newsRight">
      <div class="news-header">
        <h3>Tin tức sản phẩm</h3>
        <a href="#">Xem tất cả ></a>
      </div>

      <div class="news-list">
        <div class="news-item" v-for="blog in product?.blogs" :key="blog.id">
          <img :src="blog.thumbnail" />
          <div class="news-text">
            <p class="news-title">{{ blog.title }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { nextTick, onMounted, ref, watch } from "vue";

const props = defineProps({
  product: {
    type: Object,
    default: null,
  },
  maxHeight: {
    type: Number,
    default: 300
  }
})
const open = ref(true);
const expanded = ref(false);     // Xem thêm / Thu gọn CKEditor
const showToggle = ref(false);   // Hiện nút Xem thêm nếu nội dung cao
const contentSection = ref(null);
const newsRight = ref(null);

const toggleContent = () => {
  open.value = !open.value;
};

const toggleExpanded = () => {
  expanded.value = !expanded.value
  
  if (contentSection.value) {
    if (expanded.value) {
      // Mở rộng
      contentSection.value.style.maxHeight = 'none'
      contentSection.value.classList.remove('collapsed')
    } else {
      // Thu gọn
      contentSection.value.style.maxHeight = `${props.maxHeight}px`
      contentSection.value.classList.add('collapsed')
    }
  }
};

// Watch product changes
watch(() => props.product, (newProduct) => {
  console.log('Product changed:', newProduct)
  
  if (newProduct) {
    showToggle.value = true
    console.log('Show toggle: has product')
    
    // Đợi v-html render xong
    nextTick(() => {
      setTimeout(() => {
        if (contentSection.value) {
          console.log('Content section found:', contentSection.value)
          
          // Mặc định thu gọn
          contentSection.value.style.maxHeight = `${props.maxHeight}px`
          contentSection.value.classList.add('collapsed')
        }
      }, 100)
    })
  } else {
    showToggle.value = false
  }
}, { immediate: true })



</script>

<style scoped>
.product-wrapper {
  display: flex;
  gap: 24px;
  padding: 16px 16px 16px 0;
  margin-left: 10px;
}

.left {
  width: 65%;
  background: #f7f7f8;
    border: 1px solid #d9cece;
    border-radius: 10px;
    padding: 16px;
}

.right {
  width: 35%;
    border: 1px solid #d9cece;
    border-radius: 10px;
    background: #f7f7f8;
    padding: 16px;
}

.title {
  font-size: 22px;
  font-weight: 700;
  margin-bottom: 12px;
}

.desc {
  font-size: 15px;
  line-height: 1.6;
  margin-bottom: 16px; 
  border: 1px solid #ddd;
  border-radius: 10px;
  padding: 10px;
  background: #fff;
}

.collapse-btn {
  width: 100%;
  padding: 12px;
  background: #f2f2f2;
  border: 1px solid #ddd;
  cursor: pointer;
  display: flex;
  justify-content: space-between;
  font-size: 16px;
}

.collapse-btn span {
  transition: transform 0.2s ease;
}

.collapse-btn span.rotated {
  transform: rotate(180deg);
}

.content-section {
  overflow: hidden;
  transition: max-height 0.3s ease;
  border: 1px solid #ddd;
  border-radius: 10px;
  padding: 10px;
  background: #fff;
  margin-top: 20px;
  max-height: none; /* Default: không giới hạn */
}

.content-section.collapsed {
  max-height: 300px; /* collapsed height */
  position: relative;
}

/* Gradient fade-bottom */
.content-section.collapsed::after {
  content: "";
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 50px;
  background: linear-gradient(rgba(255,255,255,0), #fff);
}

/* Xem thêm / Thu gọn button */
.more-btn {
  display: block;
  margin-top: 10px;
  padding: 6px 12px;
  background-color: #0066ff;
  color: #fff;
  border: none;
  border-radius: 6px;
  cursor: pointer;
}
.content-section h3 {
  font-size: 18px;
  margin-top: 16px;
}

.content-section p {
  margin: 8px 0 16px;
  line-height: 1.6;
}

.image-box img {
  width: 100%;
  border-radius: 8px;
  margin: 12px 0;
}

.news-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 12px;
}

.news-header h3 {
  margin: 0;
  font-size: 20px;
}

.news-list {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.news-item {
  display: flex;
  gap: 12px;
  padding: 8px;
  background: #fff;
  border-radius: 10px;
  border: 1px solid #eee;
  cursor: pointer;
  transition: background 0.2s ease;
}

.news-item:hover {
  background: #f6f6f6;
}

.news-item img {
  width: 80px;
  height: 80px;
  border-radius: 8px;
  object-fit: cover;
}

.news-title {
  font-size: 15px;
  line-height: 1.4;
}

/* Responsive */
@media (max-width: 768px) {
  .product-wrapper {
    flex-direction: column;
  }
  
  .left, .right {
    width: 100%;
  }
  
  .right {
    position: static;
    margin-top: 20px;
  }
}

/* Desktop: Make sidebar scroll independently */
@media (min-width: 769px) {
  .right {
    position: sticky;
    top: 20px;
    align-self: flex-start;
    max-height: calc(100vh - 40px);
    overflow-y: auto;
  }
  
  .right::-webkit-scrollbar {
    width: 6px;
  }
  
  .right::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
  }
  
  .right::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 3px;
  }
  
  .right::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
  }
}
</style>
