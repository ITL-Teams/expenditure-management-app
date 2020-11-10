export type UserDeleterResponse = {
  success?: {
    message: string
  }
  error?: {
    message: string
    reason: string
  }
}
