<template>
  <div class="row">
    <!-- Columns (Statuses) -->
    <div v-for="status in statuses" :key="status.title" class="col-12 col-lg-6 col-xl-3" >
      <div class="card card-row card-secondary">
        <div class="card card-primary">
          <h5 class="card-title">
            {{ status.title }}
          </h5>
        </div>
        <div class="card-body p-3">
          <!-- Tasks -->
          <draggable class="flex-1 overflow-hidden" v-model="status.tasks" v-bind="taskDragOptions" @end="handleTaskMoved" >
            <transition-group class="flex-1 flex flex-col h-full overflow-x-hidden overflow-y-auto rounded shadow-xs" tag="div" >
              <div v-for="task in status.tasks" :key="task.id" class="card mb-5 bg-light" >
                <div class="card-body p-3 ">
                    <p>#{{ task.id }} - <span class="font-weight-bold">Order {{ task.order_lines.order.CODE }}</span>  || <span class="font-weight-bold">{{ task.order_lines.LABEL }} || qty {{ task.order_lines.qty }}</span> - {{ task.label }} - {{ task.order_lines.delivery_date }}</p>
                    <div class="float-right">
                      <div class="row">
                        <div class="col-6">
                          <p>
                            Setting Time : {{ task.SETING_TIME }}<br/>
                            Unit Time :{{ task.UNIT_TIME }}
                          </p>
                        </div>
                        <div class="col-6">
                          <p>Advancement : {{ task.ADVANCEMENT }}</p>
                        </div>
                      </div>
                    </div>
                  <!-- <a class="btn btn-outline-primary btn-sm" href="#">View</a>-->
                </div>
              </div>
              <!-- ./Tasks -->
            </transition-group>
          </draggable>
          <!-- No Tasks -->
          <div v-show="!status.tasks.length && newTaskForStatus !== status.id" class="card mb-5 bg-light" >
            <div class="card-body p-3">
              <p>No tasks yet</p>
            </div>  
          </div>
          <!-- ./No Tasks -->
        </div>
      </div>
    </div>
    <!-- ./Columns -->
  </div>
</template>

<script>
import draggable from "vuedraggable";
export default {
  components: { draggable },
  props: {
    initialData: Array
  },
  data() {
    return {
      statuses: [],
      newTaskForStatus: 0
    };
  },
  computed: {
    taskDragOptions() {
      return {
        animation: 200,
        group: "task-list",
        dragClass: "status-drag"
      };
    }
  },
  mounted() {
    // 'clone' the statuses so we don't alter the prop when making changes
    this.statuses = JSON.parse(JSON.stringify(this.initialData));
  },
  methods: {
    closeAddTaskForm() {
      this.newTaskForStatus = 0;
    },
    handleTaskMoved(evt) {
      axios.put("/task/sync", { columns: this.statuses }).catch(err => {
        console.log(err.response);
      });
    }
  }
};
</script>

<style scoped>
.status-drag {
  transition: transform 0.5s;
  transition-property: all;
}
</style>