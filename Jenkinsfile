pipeline {
  agent any
  stages {
    stage('dsd') {
      parallel {
        stage('dsd') {
          steps {
            bat 'dir'
            echo 'done'
          }
        }
        stage('dksm') {
          steps {
            echo 'dslm'
          }
        }
      }
    }
    stage('lml') {
      steps {
        echo 'l2'
      }
    }
  }
}