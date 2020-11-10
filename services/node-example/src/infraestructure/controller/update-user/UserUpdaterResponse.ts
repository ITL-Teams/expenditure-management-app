export type UserUpdaterResponse = {
  success?: {
    user: {
      id: string
      name: string
    }
  }
  error?: {
    message: string
    reason: string
  }
}
