<script>
import scheduleLessonMixin from "@Components/__mixins/scheduling/schedule-lesson";

console.log(scheduleLessonMixin);

export default {
    name: "ScheduleLessonIndex",
    mixins: [scheduleLessonMixin],
};
</script>

<template>
    <div class="schedulue-lesson">
        {{ text }}
    </div>
</template>
